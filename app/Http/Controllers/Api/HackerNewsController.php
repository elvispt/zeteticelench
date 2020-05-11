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
        $postId = $validated->get('postId');
        $bookmarkedStories = new BookmarkedStories();
        $id = $bookmarkedStories->bookmarkStory($postId, Auth::id());

        return ApiResponse::response([
            "id" => $id,
            "postId" => $postId,
            "success" => true,
        ]);
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
        $postId = $validated->get('postId');
        $bookmarkedStories = new BookmarkedStories();
        $id = $bookmarkedStories->destroyBookmarkedStory($postId, Auth::id());

        return ApiResponse::response([
            "id" => $id,
            "postId" => $postId,
            "success" => true,
        ]);
    }
}
