<?php

namespace App\Repos\HackerNews;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;

class CollapsedComments
{
    protected $cacheKey;
    protected $cacheTtl;
    protected $userId;
    protected $storyId;

    public function __construct($userId, $storyId)
    {
        $this->userId = $userId;
        $this->storyId = $storyId;
        $this->cacheKey = 'collapsed' . $this->storyId . $this->userId;
        $this->cacheTtl = 259200; // 3 days
    }

    /**
     * Gets the list of comments that should be collapsed on the page
     *
     * @return array
     */
    public function getCollapsedComments(): array
    {
        $collapsed = Cache::get($this->cacheKey);
        if (!is_array($collapsed)) {
            $collapsed = [];
        }
        return $collapsed;
    }

    /**
     * Sets a comment that should be collapsed
     *
     * @param int $commentId The identifier of the comment
     * @return bool Returns true on success, false otherwise
     */
    public function collapse(int $commentId): bool
    {
        $collapsed = Cache::get($this->cacheKey);
        if (is_array($collapsed)) {
            $collapsed[] = $commentId;
        } else {
            $collapsed = [$commentId];
        }

        return $this->setCache($collapsed);
    }

    /**
     * Removes comment from the list of collapsed comments
     *
     * @param int $commentId The identifier of the comment
     * @return bool Returns true on success, false otherwise
     */
    public function removeCollapsed(int $commentId)
    {
        $result = false;
        $collapsed = Cache::get($this->cacheKey);
        if (is_array($collapsed)) {
            $collapsed = (new Collection($collapsed))
                ->filter(function ($id) use ($commentId) {
                    return $id !== $commentId;
                })
                ->values()
                ->toArray();
            $result = $this->setCache($collapsed);
        }

        return $result;
    }

    protected function setCache($collapsed): bool
    {
        $result = false;
        try {
            $result = Cache::set($this->cacheKey, $collapsed, $this->cacheTtl);
        } catch (InvalidArgumentException $exception) {
            Log::warning(
                "Could not store collapsed comments",
                ['eMessage' => $exception->getMessage()]
            );
        }

        return $result;
    }

    public function getCacheKey()
    {
        return $this->cacheKey;
    }

    public function getCacheTtl()
    {
        return $this->cacheTtl;
    }
}
