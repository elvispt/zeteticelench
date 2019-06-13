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

class HackerNewsImport extends HnApi
{

    protected $chunkSize = 200;

    protected $maxIdCacheKey = 'maxid';

    public function importUpdatedStories()
    {
        $updatedIdsList = $this->getLiveStoriesIdList($this->updatesUri);
        $updatedIdsList = data_get($updatedIdsList, 'items', []);
        $stories = $this->concurrentRequestsForItems($updatedIdsList);
        Utils::store($stories);
    }

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

    protected function dispatchChunk(int $maxId, int $iterations = 100)
    {
        list($ids, $nextMaxId) = $this->chunk($maxId);
        if (count($ids)) {
            HnImportStories::dispatch($ids);
        }
        if ($nextMaxId > 0 && $iterations > 0) {
            $iterations -= 1;
            $this->dispatchChunk($nextMaxId, $iterations);
        } else {
            Cache::set($this->maxIdCacheKey, $nextMaxId, Carbon::now()->addDays(100));
        }
    }

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

    protected function chunk2($maxId, &$iterations)
    {
        $ids = [];
        $nextMaxId = $maxId - $this->chunkSize;
        for ($i = $nextMaxId; $i < $maxId; $i++) {
            $ids[] = $i;
        }
        $ids = $this->removeExistingStoryIds($ids);
        if (count($ids) === 0 && $iterations > 0) {
            $iterations -= 1;
            return $this->chunk($nextMaxId, $iterations);
        }
        return [$ids, $nextMaxId];
    }

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
