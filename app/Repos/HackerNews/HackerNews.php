<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;
use Illuminate\Support\Facades\Cache;

class HackerNews extends Hn
{
    protected $cacheExpiration = 80; // 30 mins

    public function __construct()
    {
        parent::__construct();
    }

    public function getTopStories(int $limit = 20, int $offset = 0, bool $forceCacheRefresh = false): array
    {
        $cacheKey = __METHOD__ . md5($limit . $offset);
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->getStories($this->topStoriesUri, $limit, $offset);
            if (is_array($stories) && count($stories)) {
                Cache::set($cacheKey, $stories, $this->cacheExpiration);
            }
        }

        return $stories;
    }

    public function getBestStories(int $limit = 20, int $offset = 0, bool $forceCacheRefresh = false): array
    {
        $cacheKey = __METHOD__ . md5($limit . $offset);
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->getStories($this->bestStoriesUri, $limit, $offset);
            if (is_array($stories) && count($stories)) {
                Cache::set($cacheKey, $stories, $this->cacheExpiration);
            }
        }

        return $stories;
    }

    public function getJobStories(int $limit = 20, int $offset = 0, bool $forceCacheRefresh = false): array
    {
        $cacheKey = __METHOD__;
        $stories = Cache::get($cacheKey);
        if (is_null($stories) || $forceCacheRefresh) {
            $stories = $this->getStories($this->jobStoriesUri, $limit, $offset);
            if (is_array($stories) && count($stories)) {
                Cache::set($cacheKey, $stories, $this->cacheExpiration);
            }
        }

        return $stories;
    }

    protected function getStories(string $uri, int $limit = 20, int $offset = 0): array
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

        return Utils::sortStoriesList($stories, $ids);
    }

    public function getStory($id)
    {
        $story = HackerNewsItem::find($id)->toArray();

        return $this->setStoryComments((object) $story);
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
