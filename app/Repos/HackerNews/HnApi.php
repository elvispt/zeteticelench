<?php

namespace App\Repos\HackerNews;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class HnApi
{
    protected string $baseUri;

    protected string $jobStoriesUri;

    protected string $updatesUri;

    protected string $itemUriFormat;

    protected int $concurrency = 10;

    /**
     * Init class properties with common configuration values
     */
    public function __construct()
    {
        $this->baseUri = config('hackernews.api_base_uri');
        $this->jobStoriesUri = config('hackernews.api_job_stories_uri');
        $this->updatesUri = config('hackernews.api_updates_uri');
        $this->itemUriFormat =
            config('hackernews.api_item_details_uri_format');
    }

    /**
     * Makes concurrent requests to HN api to obtain hn item info
     *
     * @param array<int> $storiesIdList
     *
     * @return array Returns the responses
     */
    public function concurrentRequestsForItems(array $storiesIdList)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);
        $requests = $this->requestsGenerator();
        $stories = [];
        $pool = new Pool($client, $requests($storiesIdList), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function (Response $response) use (&$stories) {
                $stories[] = $this->parseItemResponse($response);
            },
            'rejected' => static function ($reason) {
                Log::warning('Failed to make request to hn api', [$reason]);
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();

        return $stories;
    }

    /**
     * Makes a request to one of best/top/jobs api endpoints (depends on passed
     * uri).
     *
     * @param string $uri The uri to either best/top/jobs endpoint
     *
     * @return object|array Returns a list of ids of hn items
     */
    public function getLiveStoriesIdList(string $uri)
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $response = null;
        try {
            $response = $client->get($uri);
        } catch (ConnectException $exception) {
            Log::error(
                'Could not connecto to HN api',
                ['eMessage' => $exception->getMessage()]
            );
        } catch (ServerException $exception) {
            Log::error(
                'Unexpected response from HN Api',
                ['eMessage' => $exception->getMessage()]
            );
        }
        $storiesIdList = [];
        if (! is_null($response)) {
            $storiesIdList = $this->parseLiveStoriesIdListResponse($response);
        }

        return $storiesIdList;
    }

    /**
     * @return string
     */
    public function getJobStoriesUri()
    {
        return $this->jobStoriesUri;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed|stdClass
     */
    protected function parseLiveStoriesIdListResponse(
        ?ResponseInterface $response
    ) {
        $json = $response->getBody()->getContents();
        try {
            $storiesIdList = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::error(
                'Could not decode live data endpoint json response',
                ['eMessage' => $exception->getMessage()]
            );
            $storiesIdList = new stdClass();
        }

        return $storiesIdList;
    }

    /**
     * Returns a function that contains all the requests as a generator.
     *
     * @return \Closure The callback as a generator function
     */
    protected function requestsGenerator()
    {
        return function ($topStoriesIdList) {
            foreach ($topStoriesIdList as $id) {
                yield new Request(
                    'GET',
                    sprintf($this->itemUriFormat, $id)
                );
            }
        };
    }

    /**
     * Parses the response from HN api
     *
     * @param Response $response The response from the api
     *
     * @return mixed|null Returns the response parse, null on failure
     */
    protected function parseItemResponse(Response $response)
    {
        $json = $response->getBody()->getContents();
        try {
            $item = \GuzzleHttp\json_decode($json);
        } catch (InvalidArgumentException $exception) {
            Log::error(
                'Failed to decode story item',
                ['eMessage' => $exception->getMessage()]
            );
            $item = null;
        }

        return $item;
    }
}
