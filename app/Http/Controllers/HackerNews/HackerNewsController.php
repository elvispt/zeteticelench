<?php

namespace App\Http\Controllers\HackerNews;

use App\Actions\AppendDomainAction;
use App\Actions\StoriesBookmarkStatusAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\HnBookmark;
use App\Http\Requests\HnCollapseComment;
use App\Models\HackerNewsItem;
use App\Models\HackerNewsItemsBookmark;
use App\Repos\HackerNews\BookmarkedStories;
use App\Repos\HackerNews\CollapsedComments;
use App\Repos\HackerNews\HackerNews;
use App\Repos\HackerNews\HackerNewsImport;
use App\ViewModels\HackerNewsStoriesViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
     * @param Request                     $request
     * @return \Illuminate\Contracts\View\View
     */
    public function top(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getTopStories($this->perPage, $offset);

        $viewData = new HackerNewsStoriesViewModel(
            Auth::user(),
            $items,
            $currentPage,
            'hackernews.hn_top',
            'hackernews-top'
        );
        return View::make('hackernews/stories', $viewData);
    }

    /**
     * Shows the best hacker news posts. Has pagination.
     *
     * @param Request                     $request
     * @return \Illuminate\Contracts\View\View
     */
    public function best(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getBestStories($this->perPage, $offset);

        $viewData = new HackerNewsStoriesViewModel(
            Auth::user(),
            $items,
            $currentPage,
            'hackernews.hn_best',
            'hackernews-best'
        );
        return View::make('hackernews/stories', $viewData);
    }

    /**
     * Shows the new hacker news posts. Has pagination.
     *
     * @param Request                     $request
     * @return \Illuminate\Contracts\View\View
     */
    public function newStories(Request $request)
    {
        $currentPage = (int) $request->get('page', 1);
        $offset = $this->offset($currentPage);
        $hackerNews = new HackerNews();
        $items = $hackerNews->getNewStories($this->perPage, $offset);

        $viewData = new HackerNewsStoriesViewModel(
            Auth::user(),
            $items,
            $currentPage,
            'hackernews.hn_new',
            'hackernews-new'
        );
        return View::make('hackernews/new-stories', $viewData);
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

        $viewData = new HackerNewsStoriesViewModel(
            Auth::user(),
            $items,
            $currentPage,
            'hackernews.hn_job',
            'hackernews-jobs'
        );
        return View::make('hackernews/jobs', $viewData);
    }

    /**
     * Show bookmarked hacker news post
     *
     * @param Request                     $request
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
     * In a POST request make a manual import of a story with its comments
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bookmarkManualAdd(Request $request)
    {
        $id = (int) $request->get('story-id');
        $hnImport = new HackerNewsImport();
        $hnImport->importStoryWithComments($id, Auth::id());

        return back();
    }

    /**
     * In a delete request remove the bookmarks for the currently logged in user
     *
     * @param HnBookmark $request Validates the data sent
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
     * Shows the details and comments of the hacker news story
     *
     * @param int                         $id The identifier of the hacker news story
     * @param AppendDomainAction          $appendDomainAction
     * @param StoriesBookmarkStatusAction $storiesBookmarkStatusAction
     * @return \Illuminate\Contracts\View\View|void
     */
    public function item(
        $id,
        AppendDomainAction $appendDomainAction,
        StoriesBookmarkStatusAction $storiesBookmarkStatusAction
    ) {
        $hackerNews = new HackerNews();
        $story = $hackerNews->getStory($id);
        if (!$story) {
            return abort(404);
        }
        $userId = Auth::id();
        $story = Arr::first($appendDomainAction->execute([$story]));
        $story = Arr::first($storiesBookmarkStatusAction->execute([$story]));
        $collapsedComments = (new CollapsedComments($userId, $id))
            ->getCollapsedComments();
        $nBookmarkedStories = HackerNewsItemsBookmark
            ::where('user_id', $userId)
            ->count();

        return View::make('hackernews/story', [
            'story' => $story,
            'hnPostUrlFormat' => $this->hnPostUrlFormat,
            'nBookmarkedStories' => $nBookmarkedStories,
            'collapsedComments' => $collapsedComments,
        ]);
    }

    /**
     * Add a comment to the collapsed list
     *
     * @param HnCollapseComment $request
     * @param int               $id The id of the parent story
     * @return JsonResponse|void
     */
    public function itemCommentCollapse(HnCollapseComment $request, $id)
    {
        $storyExists = (new HackerNewsItem())
            ->where('id', $id)
            ->exists();
        if (!$storyExists) {
            return abort(404);
        }
        $validated = new Collection($request->validated());
        $commentId = $validated->get('commentId');
        $collapsedComments = new CollapsedComments(Auth::id(), $id);
        $collapsedComments->collapse($commentId);

        return new JsonResponse(['ok' => true]);
    }

    /**
     * Remove a comment off the collapsed list
     *
     * @param HnCollapseComment $request
     * @param int               $id The id of the parent story
     * @return JsonResponse|void
     */
    public function itemCommentRemoveCollapse(HnCollapseComment $request, $id)
    {
        $storyExists = (new HackerNewsItem())
            ->where('id', $id)
            ->exists();
        if (!$storyExists) {
            return abort(404);
        }
        $validated = new Collection($request->validated());
        $commentId = $validated->get('commentId');
        $collapsedComments = new CollapsedComments(Auth::id(), $id);
        $collapsedComments->removeCollapsed($commentId);

        return new JsonResponse(['ok' => true]);
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
}
