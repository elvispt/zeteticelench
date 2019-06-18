<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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

    /**
     * Parses and stores the given stories.
     *
     * @param array $stories The stories parsed from the HN API
     * @return int Returns the number of updated/created hn story items.
     */
    public static function store($stories): int
    {
        $map = new Collection([
            // apiField => column
            'parent' => 'parent_id',
            'kids' => 'kids',
            'dead' => 'dead',
            'url' => 'url',
            'score' => 'score',
            'title' => 'title',
            'text' => 'text',
        ]);
        return (new Collection($stories))
            ->filter(static function ($story) {
                return data_get($story, 'id', false);
            })
            ->each(static function ($story) use ($map) {
                $id = $story->id;
                $hackerNewsItem = HackerNewsItem::withTrashed()
                    ->where('id', $id)
                    ->first();
                if (is_null($hackerNewsItem)) {
                    // new item
                    $hackerNewsItem = new HackerNewsItem();
                    $hackerNewsItem->id = $id;
                    if (property_exists($story, 'by')) {
                        $hackerNewsItem->by = $story->by;
                    }
                    $time = data_get($story, 'time');
                    $created_at = Carbon::createFromTimestamp($time);
                    $hackerNewsItem->created_at = $created_at;
                    $hackerNewsItem->type = $story->type;
                }
                $map
                    ->each(static function ($column, $apiField) use (
                        $hackerNewsItem,
                        $story
                    ) {
                        if (property_exists($story, $apiField)) {
                            $hackerNewsItem->{$column} = data_get(
                                $story,
                                $apiField
                            );
                        }
                    });
                $descendants = data_get($story, 'descendants');
                if (! $descendants || $descendants < 0) {
                    $descendants = 0;
                }
                $hackerNewsItem->descendants = $descendants;
                if (property_exists($story, 'deleted')) {
                    $hackerNewsItem->deleted_at = Carbon::now();
                }
                try {
                    $hackerNewsItem->save();
                } catch (Exception $exception) {
                    Log::error(
                        "Could not save story to DB",
                        [
                            'exceptionMessage' => $exception->getMessage(),
                            'data' => print_r($story, true),
                        ]
                    );

                }
            })
            ->count();
    }
}
