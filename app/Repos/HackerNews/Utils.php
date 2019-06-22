<?php

namespace App\Repos\HackerNews;

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
}
