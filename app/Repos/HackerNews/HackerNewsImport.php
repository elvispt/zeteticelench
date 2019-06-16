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

    protected $chunkSize = 100;

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
        Log::debug("queueStoriesImport: Obtained $maxId as maxid");
        if ($maxId > 0) {
            $this->dispatchChunk($maxId);
        }
    }

    protected function dispatchChunk(int $maxId, int $iterations = 50)
    {
        [$ids, $nextMaxId] = $this->chunk($maxId);
        if (count($ids)) {
            Log::debug("dispatchChunk: Dispatching " . count($ids) . " to job");
            HnImportStories::dispatch($ids);
        }
        if ($nextMaxId > 0 && $iterations > 0) {
            $iterations -= 1;
            $this->dispatchChunk($nextMaxId, $iterations);
        } else {
            $result = Cache::set($this->maxIdCacheKey, $nextMaxId, Carbon::now()->addDays(100));
            if (!$result) {
                Log::warning("Failed to set $this->maxIdCacheKey on cache with value $nextMaxId");
            }
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
