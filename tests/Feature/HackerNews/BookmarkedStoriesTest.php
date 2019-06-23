<?php

namespace Tests\Feature\HackerNews;

use App\Models\HackerNewsItem;
use App\Models\HackerNewsItemsBookmark;
use App\Models\User;
use App\Repos\HackerNews\BookmarkedStories;
use App\Repos\HackerNews\ItemType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookmarkedStoriesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testBookmarkedStoriesShouldBeEmpty()
    {
        $userId = factory(User::class)
            ->create()
            ->id;
        $limit = 10;
        $offset = 0;
        $bookmarkedStories = new BookmarkedStories();
        $stories = $bookmarkedStories->bookmarkedStories($limit, $offset, $userId);
        $this->assertEquals(0, data_get($stories, 'total'));
        $stories = data_get($stories, 'stories');
        $this->assertIsArray($stories);
        $this->assertEquals(0, count($stories));
    }

    public function testBookmarkedStories()
    {
        $nStories = 5;
        factory(HackerNewsItem::class, 200)
            ->create();

        $stories = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit($nStories)
            ->get()
            ->pluck('id')
            ->toArray();

        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->pluck('id')
            ->first();

        foreach ($stories as $storyId) {
            $hackerNewsItemsBookmark = new HackerNewsItemsBookmark();
            $hackerNewsItemsBookmark->user_id = $userId;
            $hackerNewsItemsBookmark->hacker_news_item_id = $storyId;
            $hackerNewsItemsBookmark->created_at = $this->faker->dateTimeThisYear();
            $hackerNewsItemsBookmark->updated_at = $this->faker->dateTimeThisMonth();
            $hackerNewsItemsBookmark->save();
        }

        $limit = 10;
        $offset = 0;
        $bookmarkedStories = new BookmarkedStories();
        $storiesSaved = $bookmarkedStories->bookmarkedStories($limit, $offset, $userId);
        $this->assertEquals($nStories, data_get($storiesSaved, 'total'));
        $storiesList = data_get($storiesSaved, 'stories');
        $this->assertIsArray($storiesList);
        $this->assertEquals($nStories, count($storiesList));
    }
}
