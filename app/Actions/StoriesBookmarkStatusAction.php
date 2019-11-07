<?php

namespace App\Actions;

use App\Models\HackerNewsItemsBookmark;
use Illuminate\Pagination\LengthAwarePaginator;

class StoriesBookmarkStatusAction
{
    /**
     * Iterates over the list to find which stories are bookmarked by the
     * currently logged in user
     *
     * @param array|LengthAwarePaginator $stories The list of stories to process
     *
     * @return array|LengthAwarePaginator The list of stories with the bookmark
     * status added to each story
     */
    public function execute($stories)
    {
        $ids = [];
        foreach ($stories as $story) {
            $ids[] = $story->id;
        }
        $bookmarkedIds = $this->getBookmarkedIds($ids);
        foreach ($stories as $story) {
            $story->bookmarked = in_array($story->id, $bookmarkedIds);
        }
        return $stories;
    }

    private function getBookmarkedIds($ids)
    {
        return (new HackerNewsItemsBookmark())
            ->select('hacker_news_item_id')
            ->whereIn('hacker_news_item_id', $ids)
            ->get()
            ->pluck('hacker_news_item_id')
            ->toArray();
    }
}
