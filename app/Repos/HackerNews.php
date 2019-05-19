<?php

namespace App\Repos;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class HackerNews
{
    protected $baseUri;

    protected $topStoriesLimit;

    protected $topStoriesUri;

    protected $bestStoriesUri;

    protected $jobStoriesUri;

    protected $itemUriFormat;

    protected $concurrency = 10;

    protected $cacheExpiration = 1800; // 30 mins

    public function __construct()
    {
        $this->topStoriesLimit = 30;
        $this->baseUri = config('hackernews.api_base_uri');
        $this->topStoriesUri = config('hackernews.api_top_stories_uri');
        $this->bestStoriesUri = config('hackernews.api_best_stories_uri');
        $this->jobStoriesUri = config('hackernews.api_job_stories_uri');
        $this->itemUriFormat = config('hackernews.api_item_details_uri_format');
    }

    public function getTopStories($forceCacheRefresh = false)
    {
        $cacheKey = __METHOD__;
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->getTopStoriesFromApi();
            if (is_array($stories) && count($stories)) {
                Cache::set($cacheKey, $stories, $this->cacheExpiration);
            }
        }

        return $stories;
    }

    protected function getTopStoriesFromApi(): array
    {
        $topStoriesIdList = $this->getLiveStoriesIdList($this->topStoriesUri, $this->topStoriesLimit);
        return $this->concurrentRequestsForItems($topStoriesIdList);
    }

    protected function concurrentRequestsForItems($storiesIdList)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);
        $requests = function ($topStoriesIdList) {
            foreach ($topStoriesIdList as $id) {
                yield new Request('GET', sprintf($this->itemUriFormat, $id));
            }
        };
        $unorderedStories = [];
        $pool = new Pool($client, $requests($storiesIdList), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function (Response $response, $index) use (&$unorderedStories) {
                $json = $response->getBody()->getContents();
                try {
                    $item = \GuzzleHttp\json_decode($json);
                } catch (InvalidArgumentException $exception) {
                    Log::error("Failed to decode story item");
                    $item = null;
                }
                $unorderedStories[] = $item;
            },
            'rejected' => function ($reason, $index) use (&$unorderedStories) {
                $unorderedStories[] = null;
            }
        ]);
        $promise = $pool->promise();
        $promise->wait();

        $unorderedStories = (new Collection($unorderedStories))
            ->filter(function ($story) {
                return (!is_null($story))
                       && data_get($story, 'deleted', false) === false
                       && data_get($story, 'dead', false) === false;
            })
        ;

        return $this->sortStoriesList($unorderedStories, $storiesIdList);
    }

    protected function sortStoriesList($unorderedStories, $orderOfStories)
    {
        $orderedStories = [];
        foreach ($orderOfStories as $id) {
            foreach ($unorderedStories as $story) {
                if ($story->id === $id) {
                    $orderedStories[] = $story;
                    break;
                }
            }
        }
        return $orderedStories;
    }

    public function getBestStories($forceCacheRefresh = false)
    {
        $cacheKey = __METHOD__;
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->getBestStoriesFromApi();
            if (is_array($stories) && count($stories)) {
                Cache::set($cacheKey, $stories, $this->cacheExpiration);
            }
        }
        return $stories;
    }

    protected function getBestStoriesFromApi()
    {
        $bestStoriesIdList = $this->getLiveStoriesIdList($this->bestStoriesUri, $this->topStoriesLimit);
        return $this->concurrentRequestsForItems($bestStoriesIdList);
    }

    protected function getLiveStoriesIdList(string $uri, int $limit): array
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $response = $client->get($uri);
        $json = $response->getBody()->getContents();
        try {
            // 500 items
            $storiesIdList = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::error("Could not decode live data endpoint json response", [$exception->getMessage()]);
            $storiesIdList= [];
        }
        $storiesIdList = array_slice($storiesIdList, 0, $limit);

        return $storiesIdList;
    }

    public function getJobStories($forceCacheRefresh = false)
    {
        $cacheKey = __METHOD__;
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->getJobStoriesFromApi();
            if (is_array($stories) && count($stories)) {
                Cache::set($cacheKey, $stories, $this->cacheExpiration);
            }
        }
        return $stories;
    }

    protected function getJobStoriesFromApi()
    {
        $jobStoriesIdList = $this->getLiveStoriesIdList($this->jobStoriesUri, $this->topStoriesLimit);
        return $this->concurrentRequestsForItems($jobStoriesIdList);
    }

    public function getStory($id)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);
        $response = $client->get(sprintf($this->itemUriFormat, $id));
        $json = $response->getBody()->getContents();

        $story = null;
        try {
            $story = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::error("Could not decode hn story item", [$exception->getMessage()]);
        }

        return $this->setStoryComments($story);
    }

    protected function setStoryComments($story)
    {
        $kids = data_get($story, 'kids');
        $comments = [];
        if (is_array($kids) && count($kids)) {
            $comments = $this->comments($kids);
        }
        $story->sub = $comments;

        return $story;
    }

    protected function comments($ids)
    {
        $changed = [];
        $comments = [];
        foreach ($ids as $id) {
            $cacheKey = "comment-$id";
            $cachedComment = Cache::get($cacheKey);
            if (is_null($cachedComment)) {
                $changed[] = $id;
            } else {
                $comments[] = $cachedComment;
            }
        }

        $newComments = $this->concurrentRequestsForItems($changed);
        $comments = array_merge($newComments, $comments);

        foreach ($comments as $comment) {
            $cacheKey = "comment-$comment->id";
            Cache::set($cacheKey, $comment, 1000 + mt_rand(1, 500));
            $kids = data_get($comment, 'kids');
            if ($kids) {
                $comment->sub = $this->comments($kids);
            }
        }
        $comments = $this->sortStoriesList($comments, $ids);

        return $comments;
    }
}
