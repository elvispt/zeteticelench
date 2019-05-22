<?php

namespace  App\Http\Controllers\HackerNews;

use App\Http\Controllers\Controller;
use App\Repos\HackerNews\HackerNews;
use Illuminate\Support\Facades\View;

class HackerNewsController extends Controller
{
    public function top()
    {
        $hackerNews = new HackerNews();
        $stories = $hackerNews->getTopStories(config('hackernews.list_limit'));
        $hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $hnPostUrlFormat,
        ]);
    }

    public function best()
    {
        $hackerNews = new HackerNews();
        $stories = $hackerNews->getBestStories(config('hackernews.list_limit'));
        $hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $hnPostUrlFormat,
        ]);
    }

    public function jobs()
    {
        $hackerNews = new HackerNews();
        $stories = $hackerNews->getJobStories(config('hackernews.list_limit'));
        return View::make('hackernews/jobs', [
            'stories' => $stories,
        ]);
    }

    public function item($id)
    {
        $hackerNews = new HackerNews();
        $story = $hackerNews->getStory($id);
        $hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
        return View::make('hackernews/story', [
            'story' => $story,
            'hnPostUrlFormat' => $hnPostUrlFormat,
        ]);
    }
}
