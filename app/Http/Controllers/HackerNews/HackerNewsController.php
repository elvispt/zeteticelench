<?php

namespace App\Http\Controllers\HackerNews;

use App\Http\Controllers\Controller;
use App\Http\Requests\HnBookmark;
use App\Models\HackerNewsItemsBookmark;
use App\Repos\HackerNews\BookmarkedStories;
use App\Repos\HackerNews\HackerNews;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class HackerNewsController extends Controller
{

    protected $perPage;
    protected $hnPostUrlFormat;

    /**
     * Initialize properties with common configuration values
     */
    public function __construct()
    {
        $this->perPage = config('hackernews.list_limit');
        $this->hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
    }

    /**
     * Shows the top hacker news posts. Has pagination.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function top(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getTopStories($this->perPage, $offset);
        $stories = $this->lengthAwarePaginator(
            $currentPage,
            $items,
            route('hackernews-top')
        );
        $stories = $this->appendDomain($stories);
        $stories = $this->appendBookmarkStatus($stories);
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    /**
     * Shows the best hacker news posts. Has pagination.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function best(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getBestStories($this->perPage, $offset);
        $stories = $this->lengthAwarePaginator(
            $currentPage,
            $items,
            route('hackernews-best')
        );
        $stories = $this->appendDomain($stories);
        $stories = $this->appendBookmarkStatus($stories);
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    /**
     * Shows the new hacker news posts. Has pagination.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function newStories(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getNewStories($this->perPage, $offset);
        $stories = $this->lengthAwarePaginator(
            $currentPage,
            $items,
            route('hackernews-new')
        );
        $stories = $this->appendDomain($stories);
        $stories = $this->appendBookmarkStatus($stories);
        return View::make('hackernews/new-stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }


    /**
     * Shows jobs posting from hacker news
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function jobs(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getJobStories($this->perPage, $offset);
        $stories = $this->lengthAwarePaginator(
            $currentPage,
            $items,
            route('hackernews-jobs')
        );
        return View::make('hackernews/jobs', [
            'stories' => $stories,
        ]);
    }

    /**
     * Show bookmarked hacker news post
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function bookmarkList(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $bookmarkedStories = new BookmarkedStories();
        $items = $bookmarkedStories->bookmarkedStories($this->perPage, $offset, Auth::id());
        $stories = $this->lengthAwarePaginator(
            $currentPage,
            $items,
            route('hackernews-bookmark-list')
        );
        $stories = $this->appendDomain($stories);
        $stories = $this->appendBookmarkStatus($stories);
        return View::make('hackernews/stories', [
            'stories' => $stories,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    /**
     * In a POST request bookmarks the story for the currently logged in user
     *
     * @param HnBookmark $request Validates the data sent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bookmarkAdd(HnBookmark $request)
    {
        $validated = new Collection($request->validated());
        $storyId = $validated->get('story_id');
        $bookmarkedStories = new BookmarkedStories();
        $bookmarkedStories->bookmarkStory($storyId, Auth::id());

        return back();
    }

    /**
     * In a delete request remove the bookmarks for the currently logged in user
     *
     * @param HnBookmark $request Validates the data sent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bookmarkDestroy(HnBookmark $request)
    {
        $validated = new Collection($request->validated());
        $storyId = $validated->get('story_id');
        $bookmarkedStories = new BookmarkedStories();
        $bookmarkedStories->destroyBookmarkedStory($storyId, Auth::id());

        return back();
    }

    /**
     * Shows the details and comments of the hacker news story
     *
     * @param int $id The identifier of the hacker news story
     * @return \Illuminate\Contracts\View\View|void
     */
    public function item($id)
    {
        $hackerNews = new HackerNews();
        $story = $hackerNews->getStory($id);
        if (!$story) {
            return abort(404);
        }
        $this->appendDomain([$story]);
        return View::make('hackernews/story', [
            'story' => $story,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
        ]);
    }

    /**
     * Calculates the offset based on the current page and the number of items
     * per page.
     *
     * @param int $currentPage The current requested page.
     * @return int Returns the offset required to make requests to database.
     */
    protected function offset(int $currentPage)
    {
        return $currentPage === 1 ? 0 : ($currentPage - 1) * $this->perPage;
    }

    /**
     * Iterates over the list of stories and extracts the domain, then adds that
     * domain as a new property to the story object.
     *
     * @param array $stories The list of stories to process
     * @return array The list of stories with the domain added to each story
     */
    protected function appendDomain($stories)
    {
        foreach ($stories as $story) {
            $urlParsed = parse_url($story->url);
            $host = data_get($urlParsed, 'host');
            $domain = Str::replaceFirst('www.', '', $host);
            $story->domain = $domain;
        }
        return $stories;
    }

    /**
     * Iterates over the list to find which stories are bookmarked by the
     * currently logged in user
     *
     * @param array $stories The list of stories to process
     * @return array The list of stories with the bookmark status added to each
     * story
     */
    protected function appendBookmarkStatus($stories)
    {
        $ids = [];
        foreach ($stories as $story) {
            $ids[] = $story->id;
        }
        $bookmarkedIds = (new HackerNewsItemsBookmark())
            ->select('hacker_news_item_id')
            ->whereIn('hacker_news_item_id', $ids)
            ->get()
            ->pluck('hacker_news_item_id')
            ->toArray();
        foreach ($stories as $story) {
            $story->bookmarked = in_array($story->id, $bookmarkedIds);
        }
        return $stories;
    }

    /**
     * Grabs the story list and creates a pagination object based on the current
     * page, items, and the links to load new pages.
     *
     * @param int $currentPage The current page
     * @param object $items The list of story items
     * @param string $withPath The path to another page
     * @return mixed
     */
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
