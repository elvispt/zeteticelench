<?php

namespace App\Repos\HackerNews;

use App\Jobs\HnImportStories;
use App\Models\HackerNewsItem;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;

class HackerNewsImport extends HnApi
{
    /**
     * Size of each chunk of hacker news items ids
     *
     * @var int
     */
    protected $chunkSize = 100;

    /**
     * The cache key that stores the maximum id value
     *
     * @var string
     */
    protected $maxIdCacheKey = 'maxid' . self::class;

    /**
     * Grabs the latest new/changed stories and updates the local db
     */
    public function importUpdatedStories()
    {
        $updatedIdsList = $this->getLiveStoriesIdList($this->updatesUri);
        $updatedIdsList = data_get($updatedIdsList, 'items', []);
        $stories = $this->concurrentRequestsForItems($updatedIdsList);
        Utils::store($stories);
    }

    /**
     * Sets jobs on the queue for later importing of hacker news items.
     * Walks the id list in reverse order.
     */
    public function queueStoriesImport()
    {
        $maxId = Cache::get($this->maxIdCacheKey);
        if (is_null($maxId)) {
            $maxId = $this->getMaxItemStoryId();
        }
        if ($maxId > 0) {
            $this->dispatchChunk($maxId);
        }
    }

    /**
     * Gets a chunk of hacker news item ids and dispatches a job to the queue,
     * using recursion.
     *
     * @param int $maxId The max hn item id.
     * @param int $iterations The maximum number of recursive calls.
     */
    protected function dispatchChunk(int $maxId, int $iterations = 50)
    {
        [$ids, $nextMaxId] = $this->chunk($maxId);
        if (count($ids)) {
            HnImportStories::dispatch($ids);
        }
        if ($nextMaxId > 0 && $iterations > 0) {
            $iterations -= 1;
            $this->dispatchChunk($nextMaxId, $iterations);
        } else {
            try {
                Cache::set(
                    $this->maxIdCacheKey,
                    $nextMaxId,
                    Carbon::now()->addDays(100)
                );
            } catch (InvalidArgumentException $exception) {
                Log::warning(
                    "Fail set $this->maxIdCacheKey on cache. Val: $nextMaxId",
                    ['eMessage' => $exception->getMessage()]
                );
            }
        }
    }

    /**
     * Generates a chunk of ids against ids already present on db
     *
     * @param int $maxId The current max item id. Iterates in reverse.
     * @return array The list of ids.
     */
    protected function chunk($maxId)
    {
        $ids = [];
        $nextMaxId = $maxId;
        while (count($ids) < $this->chunkSize) {
            $nextMaxId = $maxId - $this->chunkSize;
            for ($i = $nextMaxId; $i < $maxId; $i++) {
                $ids[] = $i;
            }
            $ids = $this->removeExistingStoryIds($ids);
        }
        return [$ids, $nextMaxId];
    }

    /**
     * Gets the highest hn item id from the hn api
     *
     * @return int|null Returns the max id
     */
    protected function getMaxItemStoryId()
    {
        Log::debug("Getting max story id from API");
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        $maxItemId = null;
        try {
            $response = $client->get($this->maxItemIdUri);
            $maxItemId = $response->getBody()->getContents();
        } catch (ClientException $exception) {
            Log::alert("Could not get max item id");
        } catch (Exception $exception) {
            Log::alert("Could not get max item id");
        }
        return $maxItemId ? (int) $maxItemId : null;
    }

    /**
     * Removes all ids from the given $ids list against the ids present on the
     * local db
     *
     * @param array<int> $ids The list of generated ids
     * @return array<int> Returns the ids that do not exist on local db.
     */
    protected function removeExistingStoryIds($ids)
    {
        $foundStoriesIds = (new HackerNewsItem())
            ->withTrashed()
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
}
