<?php

namespace App\Repos\RemoteJobs;

use App\Repos\HackerNews\HackerNews;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class HackerNewsJobs implements RemoteJobsInterface
{
    public function jobs($forceCacheRefresh = true)
    {
        $hackerNews = new HackerNews();
        $hnJobs = $hackerNews->getJobStories(100, 0, $forceCacheRefresh);
        $needles = ['remote', 'Remote'];
        return (new Collection($hnJobs->stories))
            ->filter(static function ($hnJob) use ($needles) {
                $title = data_get($hnJob, 'title');
                return Str::contains($title, $needles);
            })
            ->map(function ($hnJob) {
                $this->parseJob($hnJob);
            })
            ->filter()
        ;
    }

    protected function parseJob($hnJob)
    {
        $job = new Job();
        $job->id = data_get($hnJob, 'id');
        $job->source = 'hn';
        $job->title = data_get($hnJob, 'title');
        $job->text = data_get($hnJob, 'text');
        $job->url =
            config('hackernews.site_url') . "/item?id={$job->id}";
        $url = data_get($hnJob, 'url');
        $text = trans('jobs.apply');
        $howToApply =
            '<a href="' . $url . '" target="_blank">' . $text . '</a>';
        $job->howToApply = $howToApply;
        $time = data_get($hnJob, 'created_at');
        $job->time = Carbon::createFromFormat('Y-m-d H:i:s', $time);

        return $job;
    }
}
