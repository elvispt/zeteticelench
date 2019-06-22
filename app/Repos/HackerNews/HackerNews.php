<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;

class HackerNews extends HnApi
{
    /**
     * The amount of time a story listing should be stored in cache
     *
     * @var int In seconds
     */
    protected $cacheExpiration = 70;

    /**
     * Gets hacker news top stories either from DB or cache.
     *
     * @param int  $limit The maximum number of stories
     * @param int $offset The offset (index) from which to obtain the story
     *                    items
     * @param bool $forceCacheRefresh Force the cache to be refreshed?
     * @return mixed|object Returns an object containing the list of stories
     *                      and the total number of stories available.
     */
    public function getTopStories(
        int $limit = 20,
        int $offset = 0,
        bool $forceCacheRefresh = false
    ) {
        return $this->getStories(
            $this->topStoriesUri,
            $limit,
            $offset,
            $forceCacheRefresh
        );
    }

    /**
     * Gets hacker news best stories either from DB or cache.
     *
     * @param int  $limit The maximum number of stories
     * @param int $offset The offset (index) from which to obtain the story
     *                    items
     * @param bool $forceCacheRefresh Force the cache to be refreshed?
     * @return mixed|object Returns an object containing the list of stories
     *                      and the total number of stories available.
     */
    public function getBestStories(
        int $limit = 20,
        int $offset = 0,
        bool $forceCacheRefresh = false
    ) {
        return $this->getStories(
            $this->bestStoriesUri,
            $limit,
            $offset,
            $forceCacheRefresh
        );
    }

    /**
     * Gets hacker news job stories either from DB or cache.
     *
     * @param int  $limit The maximum number of stories
     * @param int $offset The offset (index) from which to obtain the story
     *                    items
     * @param bool $forceCacheRefresh Force the cache to be refreshed?
     * @return mixed|object Returns an object containing the list of stories
     *                      and the total number of stories available.
     */
    public function getJobStories(
        int $limit = 20,
        int $offset = 0,
        bool $forceCacheRefresh = false
    ) {
        return $this->getStories(
            $this->jobStoriesUri,
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
                        "Failed to store story list on cache. Key: $cacheKey",
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
     * @return mixed|object Returns an object containing the list of stories
     *                      and the total number of stories available.
     */
    protected function storiesList(
        string $uri,
        int $limit = 20,
        int $offset = 0
    ) {
        $hackerNewsImport = new HackerNewsImport();
        $fullIdList = $hackerNewsImport->getLiveStoriesIdList($uri);
        $ids = array_slice($fullIdList, $offset, $limit);

        $items = (new HackerNewsItem())
            ->whereIn('id', $ids)
            ->get()
            ->toArray();
        $stories = [];
        foreach ($items as $item) {
            $story = (object) $item;
            $stories[] = $story;
        }
        $stories = Utils::sortStoriesList($stories, $ids);

        return (object) [
            'total' => count($fullIdList),
            'stories' => $stories,
        ];
    }

    /**
     * Get details of a single story and it's corresponding comments
     * from local db.
     *
     * @param int|null $id The story identifier
     * @return object|null Returns and object containing the story details and
     * comments
     */
    public function getStory($id)
    {
        $storyModel = HackerNewsItem::find($id);
        if ($storyModel) {
            $story = $storyModel->toArray();
        } else {
            return null;
        }

        return $this->addCommentsToStory((object) $story);
    }

    /**
     * Appends comments, and child comments to a story.
     *
     * @param object $story The story details
     * @return object Returns and object containing the story details and
     * comments
     */
    protected function addCommentsToStory($story)
    {
        $kids = data_get($story, 'kids');
        $comments = [];
        if (is_array($kids) && count($kids)) {
            $comments = $this->comments($kids);
        }
        $story->sub = $comments;

        return $story;
    }

    /**
     * Attaches all comments and child comments, using recursion.
     *
     * @param array<int> $ids An array with the id of the comments
     * @return array Returns the full list of comments
     */
    protected function comments($ids)
    {
        $commentsCollection = (new HackerNewsItem())
            ->whereIn('id', $ids)
            ->get()
            ->toArray()
        ;
        $comments = [];
        foreach ($commentsCollection as $cmt) {
            $comments[] = (object) $cmt;
        }
        foreach ($comments as $comment) {
            $kids = data_get($comment, 'kids');
            if (is_array($kids) && count($kids)) {
                $comment->sub = $this->comments($kids);
            }
        }
        $comments = Utils::sortStoriesList($comments, $ids);

        return $comments;
    }
}
