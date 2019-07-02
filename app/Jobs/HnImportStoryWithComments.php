<?php

namespace App\Jobs;

use App\Repos\HackerNews\BookmarkedStories;
use App\Repos\HackerNews\HnApi;
use App\Repos\HackerNews\StoreItems;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HnImportStoryWithComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ids;

    public $bookmarkUserId;

    /**
     * HnImportStoryWithComments constructor.
     *
     * @param int|array $ids
     * @param int|null  $bookmarkUserId
     */
    public function __construct($ids, ?int $bookmarkUserId = null)
    {
        $this->ids = $ids;
        $this->bookmarkUserId = $bookmarkUserId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ids = is_array($this->ids) ? $this->ids : [$this->ids];
        $stories = (new HnApi())
            ->concurrentRequestsForItems($ids);
        $storeItems = new StoreItems();
        $storeItems->store($stories);
        if ($this->bookmarkUserId) {
            $bookmarkedStories = new BookmarkedStories();
            $bookmarkedStories->bookmarkStory($this->ids, $this->bookmarkUserId);
        }
        foreach ($stories as $story) {
            $kids = data_get($story, 'kids', []);
            if (is_array($kids) && count($kids) > 0) {
                HnImportStoryWithComments::dispatch($kids);
            }
        }
    }
}
