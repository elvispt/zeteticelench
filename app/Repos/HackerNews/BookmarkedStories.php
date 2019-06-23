<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItemsBookmark;
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
        int $userId = null
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
}
