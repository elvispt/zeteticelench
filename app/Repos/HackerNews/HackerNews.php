<?php

namespace App\Repos\HackerNews;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;

class HackerNews
{
    /**
     * The amount of time a story listing should be stored in cache
     *
     * @var int In seconds
     */
    protected $cacheExpiration = 70;

    /**
     * Gets hacker news job stories either from DB or cache.
     *
     * @param int  $limit The maximum number of stories
     * @param int $offset The offset (index) from which to obtain the story
     *                    items
     * @param bool $forceCacheRefresh Force the cache to be refreshed?
     *
     * @return mixed|object Returns an object containing the list of stories
     *                      and the total number of stories available.
     */
    public function getJobStories(
        int $limit = 20,
        int $offset = 0,
        bool $forceCacheRefresh = false
    ) {
        return $this->getStories(
            (new HnApi())->getJobStoriesUri(),
            $limit,
            $offset,
            $forceCacheRefresh
        );
    }

    /**
     * Gets hacker news top stories either from DB or cache.
     *
     * @param string $uri               From which uri to obtain the list of
     *                                  stories
     * @param int    $limit             The maximum number of stories
     * @param int    $offset            The offset (index) from which to obtain
     *                                  the story items
     * @param bool   $forceCacheRefresh Force the cache to be refreshed?
     *
     * @return mixed|object Returns an object containing the list of stories
     *                      and the total number of stories available.
     */
    protected function getStories(
        string $uri,
        int $limit = 20,
        int $offset = 0,
        bool $forceCacheRefresh = false
    ) {
        $cacheKey = $uri . $limit . $offset;
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->storiesList($uri, $limit, $offset);
            if (data_get($stories, 'total')) {
                try {
                    Cache::set($cacheKey, $stories, $this->cacheExpiration);
                } catch (InvalidArgumentException $exception) {
                    Log::error(
                        "Failed to store story list on cache. Key: ${cacheKey}",
                        ['exceptionMessage' => $exception->getMessage()]
                    );
                }
            }
        }

        return $stories;
    }

    /**
     * Obtains the story list by making a request to the HN api to obtain the
     * story ids then getting the story details from the local db.
     *
     * @param string $uri    From which uri to obtain the list of stories
     * @param int    $limit  The maximum number of stories
     * @param int    $offset The offset (index) from which to obtain the story
     *                       items
     *
     * @return mixed|object Returns an object containing the list of stories
     *                      and the total number of stories available.
     */
    protected function storiesList(
        string $uri,
        int $limit = 20,
        int $offset = 0
    ) {
        $hnApi = new HnApi();
        $fullIdList = $hnApi->getLiveStoriesIdList($uri);

        return Utils::storiesListFromDb($fullIdList, $limit, $offset);
    }
}
