<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HnBookmark;
use App\Repos\HackerNews\BookmarkedStories;
use App\ViewModels\HackerNewsStoriesViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class HackerNewsController extends Controller
{
    /**
     * Show bookmarked hacker news post
     *
     * @param Request                     $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function bookmarkList(Request $request)
    {
        $userId = Auth::id();
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $bookmarkedStories = new BookmarkedStories();
        $items = $bookmarkedStories->bookmarkedStories(
            $this->perPage,
            $offset,
            $userId
        );

        $viewData = new HackerNewsStoriesViewModel(
            Auth::user(),
            $items,
            $currentPage,
            'hackernews.hn_bookmarked',
            'hackernews-bookmark-list',
            HackerNewsStoriesViewModel::SHOW_MANUAL_BOOKMARK_FORM
        );
        return View::make('hackernews/stories', $viewData);
    }

    /**
     * In a POST request bookmarks the story for the currently logged in user
     *
     * @param HnBookmark $request Validates the data sent
     *
     * @return JsonResponse
     */
    public function bookmarkAdd(HnBookmark $request): JsonResponse
    {
        $validated = new Collection($request->validated());
        $storyId = $validated->get('story_id');
        $bookmarkedStories = new BookmarkedStories();
        $bookmarkedStories->bookmarkStory($storyId, Auth::id());

        return new JsonResponse(['ok' => true]);
    }

    /**
     * In a delete request remove the bookmarks for the currently logged in user
     *
     * @param HnBookmark $request Validates the data sent
     *
     * @return JsonResponse
     */
    public function bookmarkDestroy(HnBookmark $request)
    {
        $validated = new Collection($request->validated());
        $storyId = $validated->get('story_id');
        $bookmarkedStories = new BookmarkedStories();
        $bookmarkedStories->destroyBookmarkedStory($storyId, Auth::id());

        return new JsonResponse(['ok' => true]);
    }

    /**
     * Calculates the offset based on the current page and the number of items
     * per page.
     *
     * @param int $currentPage The current requested page.
     *
     * @return int Returns the offset required to make requests to database.
     */
    protected function offset(int $currentPage)
    {
        return $currentPage === 1 ? 0 : ($currentPage - 1) * $this->perPage;
    }
}
