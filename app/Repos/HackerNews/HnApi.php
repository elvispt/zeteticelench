<?php

namespace App\Repos\HackerNews;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class HnApi
{
    protected $baseUri;

    protected $topStoriesUri;

    protected $bestStoriesUri;

    protected $jobStoriesUri;

    protected $updatesUri;

    protected $itemUriFormat;

    protected $maxItemIdUri;

    protected $concurrency = 50;

    public function __construct()
    {
        $this->baseUri = config('hackernews.api_base_uri');
        $this->topStoriesUri = config('hackernews.api_top_stories_uri');
        $this->bestStoriesUri = config('hackernews.api_best_stories_uri');
        $this->jobStoriesUri = config('hackernews.api_job_stories_uri');
        $this->updatesUri = config('hackernews.api_updates_uri');
        $this->itemUriFormat = config('hackernews.api_item_details_uri_format');
        $this->maxItemIdUri = config('hackernews.api_item_max_id');
    }

    public function concurrentRequestsForItems($storiesIdList)
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
            'fulfilled' => static function (Response $response) use (&$unorderedStories) {
                $json = $response->getBody()->getContents();
                try {
                    $item = \GuzzleHttp\json_decode($json);
                } catch (InvalidArgumentException $exception) {
                    Log::error("Failed to decode story item");
                    $item = null;
                }
                $unorderedStories[] = $item;
            },
            'rejected' => static function ($reason) {
                Log::warning("Failed to make request to hn api", [$reason]);
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();

        return $unorderedStories;
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
}
