<?php

namespace  App\Http\Controllers\HackerNews;

use App\Http\Controllers\Controller;
use App\Repos\HackerNews;
use Illuminate\Support\Facades\View;

class HackerNewsController extends Controller
{
    public function top()
    {
        $hackerNews = new HackerNews();
        $stories = $hackerNews->getTopStories();
        $hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $hnPostUrlFormat,
        ]);
    }

    public function best()
    {
        $hackerNews = new HackerNews();
        $stories = $hackerNews->getBestStories();
        $hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $hnPostUrlFormat,
        ]);
    }

    public function jobs()
    {
        $hackerNews = new HackerNews();
        $stories = $hackerNews->getJobStories();
        return View::make('hackernews/jobs', [
            'stories' => $stories
        ]);
    }
}
