<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;
use Illuminate\Support\Facades\Cache;

class HackerNews extends HnApi
{
    /**
     * The amount of time a story listing should be stored in cache
     *
     * @var int In seconds
     */
    protected $cacheExpiration = 70;

    public function getTopStories(int $limit = 20, int $offset = 0, bool $forceCacheRefresh = false)
    {
        return $this->getStories($this->topStoriesUri, $limit, $offset, $forceCacheRefresh);
    }

    public function getBestStories(int $limit = 20, int $offset = 0, bool $forceCacheRefresh = false)
    {
        return $this->getStories($this->bestStoriesUri, $limit, $offset, $forceCacheRefresh);
    }

    public function getJobStories(int $limit = 20, int $offset = 0, bool $forceCacheRefresh = false)
    {
        return $this->getStories($this->jobStoriesUri, $limit, $offset, $forceCacheRefresh);
    }

    protected function getStories(string $uri, int $limit = 20, int $offset = 0, $forceCacheRefresh = false)
    {
        $cacheKey = $uri . $limit . $offset;
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->storiesList($uri, $limit, $offset);
            if (data_get($stories, 'total')) {
                Cache::set($cacheKey, $stories, $this->cacheExpiration);
            }
        }

        return $stories;
    }

    protected function storiesList(string $uri, int $limit = 20, int $offset = 0)
    {
        $hackerNewsImport = new HackerNewsImport();
        $fullIdList = $hackerNewsImport->getLiveStoriesIdList($uri);
        $ids = array_slice($fullIdList, $offset, $limit);

        $items = (new HackerNewsItem())
            ->whereIn('id', $ids)
            ->get()
            ->toArray()
        ;
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

    public function getStory($id)
    {
        $story = HackerNewsItem::find($id)->toArray();

        return $this->addCommentsToStory((object) $story);
    }

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
