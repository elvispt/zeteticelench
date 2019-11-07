<?php

namespace App\Repos\HackerNews;

use App\Jobs\HnImportStories;
use App\Jobs\HnImportStoryWithComments;
use App\Models\HackerNewsItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Log;
use Psr\SimpleCache\InvalidArgumentException;

class HackerNewsImport
{

    protected $cacheKey;

    protected $expiration;

    /**
     * Size of each chunk of ids to send to queue
     *
     * @var int
     */
    protected $chunkSize = 100;

    /**
     * Sets the list of top stories ids into a queue
     *
     * @param HnApi $hnApi
     */
    public function importTop(HnApi $hnApi): void
    {
        $this->importStories($hnApi->getTopStoriesUri(), $hnApi);
    }

    /**
     * Sets the list of best stories ids into a queue
     *
     * @param HnApi $hnApi
     */
    public function importBest(HnApi $hnApi): void
    {
        $this->importStories($hnApi->getBestStoriesUri(), $hnApi);
    }

    /**
     * Sets the list of new stories ids into a queue
     *
     * @param HnApi $hnApi
     */
    public function importNew(HnApi $hnApi): void
    {
        $this->importStories($hnApi->getNewStoriesUri(), $hnApi);
    }

    /**
     * Sets the list of job stories ids into a queue
     *
     * @param HnApi $hnApi
     */
    public function importJobs(HnApi $hnApi): void
    {
        $this->importStories($hnApi->getJobStoriesUri(), $hnApi);
    }

    /**
     * Get the latest hacker news items that were changed
     *
     * @param HnApi $hnApi
     */
    public function importUpdatedStories(HnApi $hnApi): void
    {
        $updatedIdsList = $hnApi->getLiveStoriesIdList($hnApi->getUpdatesUri());
        $updatedIdsList = data_get($updatedIdsList, 'items', []);
        $stories = $hnApi->concurrentRequestsForItems($updatedIdsList);
        $storeItems = new StoreItems();
        $storeItems->store($stories);
        Log::debug(
            "Update import result",
            ['changes' => $storeItems->getChanges()]
        );
    }

    /**
     * Import a single story and its comments, by using a queue.
     *
     * @param int      $storyId The identifier of the story.
     * @param int|null $bookmarkUserId The user to bookmark this story with.
     */
    public function importStoryWithComments(
        int $storyId,
        ?int $bookmarkUserId = null
    ): void {
        HnImportStoryWithComments::dispatch($storyId, $bookmarkUserId);
    }

    /**
     * Sets jobs on the queue for later importing of hacker news items.
     * Walks the id list in reverse order.
     *
     * @param string $uri
     * @param HnApi  $hnApi
     */
    protected function importStories(string $uri, HnApi $hnApi): void
    {
        $cacheKey = $this->cacheKey ? $this->cacheKey : self::class . $uri;
        $newStoriesIds = $hnApi->getLiveStoriesIdList($uri);
        $newStoriesIds = $this->diffWithCachedIds($newStoriesIds, $cacheKey);
        if (count($newStoriesIds) === 0) {
            return;
        }

        $storyIdsToImport = $this->diffWithExistingStories($newStoriesIds);
        $this->queueJobs($storyIdsToImport);

        try {
            $expiration = $this->expiration ? $this->expiration : 300;
            Cache::set($cacheKey, $storyIdsToImport, $expiration);
        } catch (InvalidArgumentException $exception) {
            Log::error(
                "Cache: settting ids list when importing stories",
                ['eMesssage' => $exception->getMessage()]
            );
        }
    }

    /**
     * Checks which item ids already exists on cache and removes those from the
     * final id list.
     *
     * @param array  $newIds The list of new ids obtained.
     * @param string $cacheKey The cache where the list of the previously stored
     *                         ids are set.
     *
     * @return array Returns the ids that have not yet been processed.
     */
    protected function diffWithCachedIds(array $newIds, string $cacheKey): array
    {
        $cachedStoryIds = Cache::get($cacheKey);

        return (new Collection($newIds))
            ->diff($cachedStoryIds)
            ->values()
            ->toArray();
    }

    /**
     * Checks which item ids already exists on DB and removes those from the
     * final id list.
     *
     * @param array $newIds The list of new ids obtained.
     *
     * @return array Returns the ids that do not exist on db.
     */
    protected function diffWithExistingStories(array $newIds): array
    {
        $existingStoryIds = HackerNewsItem::findMany([$newIds])
            ->pluck('id');

        return (new Collection($newIds))
            ->diff($existingStoryIds)
            ->values()
            ->toArray();
    }

    /**
     * Gets the list of ids and separates into chunks of $this->chunkSize and
     * dispatches that list into a Job class for later processing by the queue
     * worker.
     *
     * @param array $storyIdsToImport The list of ids to dispatch to a queue.
     */
    protected function queueJobs(array $storyIdsToImport): void
    {
        $list = [];
        foreach ($storyIdsToImport as $index => $storyId) {
            $list[] = $storyId;
            if (count($list) === $this->chunkSize
                || count($storyIdsToImport) === $index + 1) {
                HnImportStories::dispatch($list);
                $list = [];
            }
        }
    }

    /**
     * @param mixed $cacheKey
     *
     * @return HackerNewsImport
     */
    public function setCacheKey($cacheKey)
    {
        $this->cacheKey = $cacheKey;

        return $this;
    }

    /**
     * @param mixed $expiration
     *
     * @return HackerNewsImport
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }
}
