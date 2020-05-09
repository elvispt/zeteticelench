<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HnBookmark;
use App\Http\Responses\ApiResponse;
use App\Repos\HackerNews\BookmarkedStories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class HackerNewsController extends Controller
{
    /**
     * Show bookmarked hacker news post
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function bookmarks(Request $request): JsonResponse
    {
        $bookmarkedStories = new BookmarkedStories();
        $bookmarkedStoriesIds = $bookmarkedStories->bookmarkedStories(Auth::id());

        return ApiResponse::response($bookmarkedStoriesIds);
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
