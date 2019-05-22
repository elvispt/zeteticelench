<?php

namespace App\Repos\HackerNews;

class Hn
{
    protected $baseUri;

    protected $topStoriesUri;

    protected $bestStoriesUri;

    protected $jobStoriesUri;

    protected $itemUriFormat;

    public function __construct()
    {
        $this->baseUri = config('hackernews.api_base_uri');
        $this->topStoriesUri = config('hackernews.api_top_stories_uri');
        $this->bestStoriesUri = config('hackernews.api_best_stories_uri');
        $this->jobStoriesUri = config('hackernews.api_job_stories_uri');
        $this->itemUriFormat = config('hackernews.api_item_details_uri_format');
    }
}
