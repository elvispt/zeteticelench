<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;
use Illuminate\Support\Carbon;

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
        foreach ($stories as $story) {
            $id = data_get($story, 'id');
            if (is_null($id)) {
                continue;
            }
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
            if (property_exists($story, 'descendants')) {
                $hackerNewsItem->descendants = $story->descendants;
            }
            if (property_exists($story, 'parent')) {
                $hackerNewsItem->parent_id = $story->parent;
            }
            if (property_exists($story, 'kids')) {
                $hackerNewsItem->kids = $story->kids;
            }
            if (property_exists($story, 'deleted')) {
                $hackerNewsItem->deleted_at = Carbon::now();
            }
            if (property_exists($story, 'dead')) {
                $hackerNewsItem->dead = $story->dead;
            }
            if (property_exists($story, 'url')) {
                $hackerNewsItem->url = $story->url;
            }
            if (property_exists($story, 'score')) {
                $hackerNewsItem->score = $story->score;
            }
            if (property_exists($story, 'title')) {
                $hackerNewsItem->title = $story->title;
            }
            if (property_exists($story, 'text')) {
                $hackerNewsItem->text = $story->text;
            }
            try {
                $hackerNewsItem->save();
            } catch (\Exception $e) {
                dd($e, $story, $hackerNewsItem);
            }

        }

        return count($stories);
    }
}
