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

class HackerNewsImport extends HnApi
{
    protected $updatesUri;

    protected $concurrency = 50;

    public function __construct()
    {
        parent::__construct();
        $this->updatesUri = config('hackernews.api_updates_uri');
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
        $this->addCommentsToStories($stories);
    }

    public function importBestStories()
    {
        $bestStoriesFullIdList = $this->getLiveStoriesIdList($this->bestStoriesUri);
        $bestStoriesIdList = $this->removeExistingStoryIds($bestStoriesFullIdList);
        $stories = $this->concurrentRequestsForItems($bestStoriesIdList);
        Utils::store($stories);
        $this->addCommentsToStories($stories);
    }

    public function importJobStories()
    {
        $jobStoriesFullIdList = $this->getLiveStoriesIdList($this->jobStoriesUri);
        $jobStoriesIdList = $this->removeExistingStoryIds($jobStoriesFullIdList);
        $stories = $this->concurrentRequestsForItems($jobStoriesIdList);
        Utils::store($stories);
        $this->addCommentsToStories($stories);
    }

    public function importUpdatedStories()
    {
        $updatedIdsList = $this->getLiveStoriesIdList($this->updatesUri);
        $updatedIdsList = data_get($updatedIdsList, 'items', []);
        $stories = $this->concurrentRequestsForItems($updatedIdsList);
        Utils::store($stories);
    }

    public function getLiveStoriesIdList(string $uri)
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
            'rejected' => function ($reason, $index) {
                Log::warning("Failed to make request to hn api", [$reason]);
            },
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

    protected function addCommentsToStories($stories)
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
