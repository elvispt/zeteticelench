<?php

namespace App\Http\Controllers\HackerNews;

use App\Http\Controllers\Controller;
use App\Repos\HackerNews\HackerNews;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;

class HackerNewsController extends Controller
{

    protected $perPage;
    protected $hnPostUrlFormat;

    public function __construct()
    {
        $this->perPage = config('hackernews.list_limit');
        $this->hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
    }

    public function top(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $hackerNews = new HackerNews();
        $offset = $currentPage === 1 ? 0 : ($currentPage - 1 ) * $this->perPage;
        $items = $hackerNews->getTopStories($this->perPage, $offset);
        $stories = new LengthAwarePaginator($items->stories, $items->total, $this->perPage, $currentPage);
        $stories->withPath(route('hackernews-top'));
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    public function best(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $hackerNews = new HackerNews();
        $offset = $currentPage === 1 ? 0 : ($currentPage - 1 ) * $this->perPage;
        $items = $hackerNews->getBestStories($this->perPage, $offset);
        $stories = new LengthAwarePaginator($items->stories, $items->total, $this->perPage, $currentPage);
        $stories->withPath(route('hackernews-best'));
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    public function jobs(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $hackerNews = new HackerNews();
        $offset = $currentPage === 1 ? 0 : ($currentPage - 1 ) * $this->perPage;
        $items = $hackerNews->getJobStories($this->perPage, $offset);
        $stories = new LengthAwarePaginator($items->stories, $items->total, $this->perPage, $currentPage);
        $stories->withPath(route('hackernews-jobs'));
        return View::make('hackernews/jobs', [
            'stories' => $stories,
        ]);
    }

    public function item($id)
    {
        $hackerNews = new HackerNews();
        $story = $hackerNews->getStory($id);
        return View::make('hackernews/story', [
            'story' => $story,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }
}
