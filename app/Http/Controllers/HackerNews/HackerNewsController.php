<?php

namespace App\Http\Controllers\HackerNews;

use App\Http\Controllers\Controller;
use App\Repos\HackerNews\HackerNews;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

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
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getTopStories($this->perPage, $offset);
        $stories = $this->lengthAwarePaginator($currentPage, $items, route('hackernews-top'));
        $this->appendDomain($stories);
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    public function best(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getBestStories($this->perPage, $offset);
        $stories = $this->lengthAwarePaginator($currentPage, $items, route('hackernews-best'));
        $this->appendDomain($stories);
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    public function jobs(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getJobStories($this->perPage, $offset);
        $stories = $this->lengthAwarePaginator($currentPage, $items, route('hackernews-jobs'));
        return View::make('hackernews/jobs', [
            'stories' => $stories,
        ]);
    }

    protected function offset($currentPage)
    {
        return $currentPage === 1 ? 0 : ($currentPage - 1) * $this->perPage;
    }

    public function item($id)
    {
        $hackerNews = new HackerNews();
        $story = $hackerNews->getStory($id);
        $this->appendDomain([$story]);
        return View::make('hackernews/story', [
            'story' => $story,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    protected function appendDomain($stories)
    {
        foreach ($stories as $story) {
            $urlParsed = parse_url($story->url);
            $host = data_get($urlParsed, 'host');
            $domain = Str::replaceFirst('www.', '', $host);
            $story->domain = $domain;
        }
    }

    protected function lengthAwarePaginator($currentPage, $items, $withPath)
    {
        $stories = new LengthAwarePaginator(
            $items->stories,
            $items->total,
            $this->perPage,
            $currentPage
        );
        $stories->withPath($withPath);
        $stories->onEachSide(1);

        return $stories;
    }
}
