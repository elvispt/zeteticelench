<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class HackerNews
{
    protected $baseUri;

    protected $itemUriFormat;

    protected $topStoriesUri;

    protected $bestStoriesUri;

    protected $jobStoriesUri;

    protected $updatesUri;

    protected $concurrency = 50;

    protected $limitStories = 10;

    public function __construct()
    {
        $this->baseUri = config('hackernews.api_base_uri');
        $this->topStoriesUri = config('hackernews.api_top_stories_uri');
        $this->bestStoriesUri = config('hackernews.api_best_stories_uri');
        $this->jobStoriesUri = config('hackernews.api_job_stories_uri');
        $this->updatesUri = config('hackernews.api_updates_uri');
        $this->itemUriFormat = config('hackernews.api_item_details_uri_format');
    }

    public function importAll()
    {
        $this->importTopStories();
        $this->importBestStories();
        $this->importJobStories();
        $this->importUpdatedStories();
    }

    public function importTopStories()
    {
        $topStoriesFullIdList = $this->getLiveStoriesIdList($this->topStoriesUri);
        $topStoriesIdList = $this->removeExistingStoryIds($topStoriesFullIdList);
        $stories = $this->concurrentRequestsForItems($topStoriesIdList);
        Utils::store($stories);
        $this->setComments($stories);
    }

    public function importBestStories()
    {
        $bestStoriesFullIdList = $this->getLiveStoriesIdList($this->bestStoriesUri);
        $bestStoriesIdList = $this->removeExistingStoryIds($bestStoriesFullIdList);
        $stories = $this->concurrentRequestsForItems($bestStoriesIdList);
        Utils::store($stories);
        $this->setComments($stories);
    }

    public function importJobStories()
    {
        $jobStoriesFullIdList = $this->getLiveStoriesIdList($this->jobStoriesUri);
        $jobStoriesIdList = $this->removeExistingStoryIds($jobStoriesFullIdList);
        $stories = $this->concurrentRequestsForItems($jobStoriesIdList);
        Utils::store($stories);
        $this->setComments($stories);
    }

    public function importUpdatedStories()
    {
        $updatedIdsList = $this->getLiveStoriesIdList($this->updatesUri);
        $updatedIdsList = data_get($updatedIdsList, 'items', []);
        $stories = $this->concurrentRequestsForItems($updatedIdsList);
        Utils::store($stories);
    }

    protected function getLiveStoriesIdList(string $uri)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $response = $client->get($uri);
        $json = $response->getBody()->getContents();
        try {
            $storiesIdList = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::error("Could not decode live data endpoint json response", [$exception->getMessage()]);
            $storiesIdList= [];
        }

        return $storiesIdList;
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
            'fulfilled' => function (Response $response) use (&$unorderedStories) {
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
            }
        ]);
        $promise = $pool->promise();
        $promise->wait();

        return $unorderedStories;
    }

    protected function removeExistingStoryIds($ids)
    {
        $foundStoriesIds = (new HackerNewsItem())
            ->select('id')
            ->whereIn('id', $ids)
            ->get()
            ->pluck('id')
            ->toArray()
        ;
        return (new Collection($ids))
            ->diff($foundStoriesIds)
            ->toArray();
    }

    protected function setComments($stories)
    {
        foreach ($stories as $story) {
            $kids = data_get($story, 'kids');
            if (is_array($kids) && count($kids)) {
                $this->comments($kids);
            }
        }
    }

    protected function comments($ids)
    {
        $comments = $this->concurrentRequestsForItems($ids);

        Utils::store($comments);

        foreach ($comments as $comment) {
            $kids = data_get($comment, 'kids');
            if ($kids) {
                $subComments = $this->comments($kids);
                Utils::store($subComments);
            }
        }

        return $comments;
    }
}
