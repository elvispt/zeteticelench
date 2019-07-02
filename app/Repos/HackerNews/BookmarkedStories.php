<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItemsBookmark;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class BookmarkedStories
{
    /**
     * Shows the list of bookmarked stories for the given user
     *
     * @param int      $limit The maximum number of stories to show
     * @param int      $offset The offset of list of stories
     * @param int|null $userId The identifier of the user
     * @return object Returns an object contained the total number of stories
     *                and the stories.
     */
    public function bookmarkedStories(
        int $limit = 20,
        int $offset = 0,
        ?int $userId = null
    ) {
        $hnIds = (new HackerNewsItemsBookmark())
            ->select('hacker_news_item_id')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->pluck('hacker_news_item_id')
            ->toArray()
        ;

        return Utils::storiesListFromDb($hnIds, $limit, $offset);
    }

    /**
     * Bookmarks a story for the user
     *
     * @param int $hackerNewsItemId The identifier of the story
     * @param int $userId           The identifier of the user
     * @return int Returns the id of hacker_news_items_bookmarks
     */
    public function bookmarkStory(int $hackerNewsItemId, int $userId): int
    {
        $hackerNewsItemsBookmark = (new HackerNewsItemsBookmark())
            ->where('user_id', $userId)
            ->where('hacker_news_item_id', $hackerNewsItemId)
            ->first();
        if (! $hackerNewsItemsBookmark) {
            $hackerNewsItemsBookmark = new HackerNewsItemsBookmark();
            $hackerNewsItemsBookmark->user_id = $userId;
            $hackerNewsItemsBookmark->hacker_news_item_id = $hackerNewsItemId;

            try {
                $hackerNewsItemsBookmark->save();
            } catch (QueryException $exception) {
                Log::error(
                    "Failed to bookmark story",
                    [
                        'eMessage' => $exception->getMessage(),
                        'userId' => $userId,
                        'hackerNewsItemId' => $hackerNewsItemId,
                    ]
                );
            }
        }

        return $hackerNewsItemsBookmark->id;
    }

    /**
     * Removes a bookmarked story for the user
     *
     * @param int $hackerNewsItemId The identifier of the story.
     * @param int $userId           The identifier of the user.
     * @return bool Returns true on success, false otherwise.
     */
    public function destroyBookmarkedStory(
        int $hackerNewsItemId,
        int $userId
    ): bool {
        $hackerNewsItemsBookmark = (new HackerNewsItemsBookmark())
            ->where('user_id', $userId)
            ->where('hacker_news_item_id', $hackerNewsItemId)
            ->first();
        $isDeleted = false;
        if ($hackerNewsItemsBookmark) {
            try {
                $isDeleted = $hackerNewsItemsBookmark->delete();
            } catch (Exception $exception) {
                Log::error(
                    "Failed to destroy bookmark",
                    [
                        'eMessage' => $exception->getMessage(),
                        'userId' => $userId,
                        'hackerNewsItemId' => $hackerNewsItemId,
                    ]
                );
            }
        }

        return !!$isDeleted;
    }
}