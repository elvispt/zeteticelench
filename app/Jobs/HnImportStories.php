<?php

namespace App\Jobs;

use App\Repos\HackerNews\HnApi;
use App\Repos\HackerNews\Utils;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HnImportStories implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ids;

    public function __construct($ids)
    {
        $this->ids = is_array($ids) ? $ids : [];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stories = (new HnApi())
            ->concurrentRequestsForItems($this->ids);
        Utils::store($stories);
    }
}
