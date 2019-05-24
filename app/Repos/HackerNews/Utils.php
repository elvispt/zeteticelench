<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Utils
{
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

    public static function store($stories): int
    {
        $map = [
            // apiField => column
            'descendants' => 'descendants',
            'parent' => 'parent_id',
            'kids' => 'kids',
            'dead' => 'dead',
            'url' => 'url',
            'score' => 'score',
            'title' => 'title',
            'text' => 'text',
        ];
        return (new Collection($stories))
            ->filter(static function ($story) {
                return data_get($story, 'id', false);
            })
            ->each(static function ($story) use ($map) {
                $id = $story->id;
                $hackerNewsItem = (HackerNewsItem::withTrashed())
                    ->where('id', $id)
                    ->first();
                if (is_null($hackerNewsItem)) {
                    // new item
                    $hackerNewsItem = new HackerNewsItem();
                    $hackerNewsItem->id = $id;
                    if (property_exists($story, 'by')) {
                        $hackerNewsItem->by = $story->by;
                    }
                    $hackerNewsItem->created_at = Carbon::createFromTimestamp($story->time);
                    $hackerNewsItem->type = $story->type;
                }
                (new Collection($map))
                    ->each(function ($column, $apiField) use ($hackerNewsItem, $story) {
                        if (property_exists($story, $apiField)) {
                            $hackerNewsItem->{$column} = data_get($story, $apiField);
                        }
                    });
                if (property_exists($story, 'deleted')) {
                    $hackerNewsItem->deleted_at = Carbon::now();
                }
                try {
                    $hackerNewsItem->save();
                } catch (Exception $exception) {
                    Log::error("Could not save story to DB", [print_r($story, true)]);
                }
            })
            ->count();
    }
}
