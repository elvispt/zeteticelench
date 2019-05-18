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

    protected $itemUriFormat;

    protected $concurrency = 10;

    public function __construct()
    {
        $this->topStoriesLimit = 30;
        $this->baseUri = config('hackernews.api_base_uri');
        $this->topStoriesUri = config('hackernews.api_top_stories_uri');
        $this->itemUriFormat = config('hackernews.api_item_details_uri_format');
    }

    public function getTopStories($forceCacheRefresh = false)
    {
        $cacheKey = __METHOD__;
        $expiration = 1800; // 30 mins
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->getTopStoriesFromApi();
            if (is_array($stories) && count($stories)) {
                Cache::set($cacheKey, $stories, $expiration);
            }
        }
        return $stories;
    }

    protected function getTopStoriesFromApi(): array
    {
        $topStoriesIdList = $this->getTopStoriesList();
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);
        $requests = function ($topStoriesIdList) {
            foreach ($topStoriesIdList as $id) {
                yield new Request('GET', sprintf($this->itemUriFormat, $id));
            }
        };
        $unorderedStories = [];
        $pool = new Pool($client, $requests($topStoriesIdList), [
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
                return data_get($story, 'type') === 'story'
                       && data_get($story, 'deleted', false) === false
                       && data_get($story, 'dead', false) === false;
            })
        ;

        return $this->sortStoriesList($unorderedStories, $topStoriesIdList);
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

    protected function getTopStoriesList(): array
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $response = $client->get($this->topStoriesUri);
        $json = $response->getBody()->getContents();
        try {
            // 500 items
            $topStoriesIdList = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::error("Could not decode topstories endpoint json response");
            $topStoriesIdList= [];
        }
        $topStoriesIdList = array_slice($topStoriesIdList, 0, $this->topStoriesLimit);

        return $topStoriesIdList;
    }
}
