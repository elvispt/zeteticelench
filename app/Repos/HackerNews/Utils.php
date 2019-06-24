<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;

class Utils
{
    /**
     * Sorts the given list of stories against the expect order of items set on
     * $orderOfStories.
     *
     * @param array      $unorderedStories
     * @param array<int> $orderOfStories
     * @return array Returns the list of stories sorted according to
     * $orderOfStories
     */
    public static function sortStoriesList($unorderedStories, $orderOfStories)
    {
        $orderedStories = [];
        foreach ($orderOfStories as $id) {
            foreach ($unorderedStories as $story) {
                if ($story->id === $id) {
                    $orderedStories[] = $story;
                    break;
                }
            }
        }
        return $orderedStories;
    }

    public static function storiesListFromDb(
        array $fullIdList,
        int $limit = 20,
        int $offset = 0
    ) {
        $ids = array_slice($fullIdList, $offset, $limit);
        $items = (new HackerNewsItem())
            ->whereIn('id', $ids)
            ->get()
            ->toArray();
        $stories = [];
        foreach ($items as $item) {
            $story = (object) $item;
            $stories[] = $story;
        }
        $stories = Utils::sortStoriesList($stories, $ids);

        return (object) [
            'total' => count($fullIdList),
            'stories' => $stories,
        ];
    }
}
