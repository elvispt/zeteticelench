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


    public function testBookmarkHackerNewsStory()
    {
        factory(HackerNewsItem::class, 200)
            ->create();
        $nStories = 1;
        $storyId = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit($nStories)
            ->pluck('id')
            ->first();

        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->pluck('id')
            ->first();

        $bookmarkedStories = new BookmarkedStories();
        $bookmarkId = $bookmarkedStories->bookmarkStory($storyId, $userId);
        $this->assertIsInt($bookmarkId);
        $this->assertTrue($bookmarkId > 0);
        $this->assertDatabaseHas('hacker_news_items_bookmarks', [
            'id' => $bookmarkId,
            'hacker_news_item_id' => $storyId,
            'user_id' => $userId,
        ]);
    }

    public function testDestroyBookmarkedStoryFailsWithInvalidStoryId()
    {
        factory(HackerNewsItem::class, 200)
            ->create();
        $storyId = 8465465465;

        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->pluck('id')
            ->first();

        $bookmarkedStories = new BookmarkedStories();
        $result = $bookmarkedStories->destroyBookmarkedStory($storyId, $userId);
        $this->assertIsBool($result);
        $this->assertFalse($result);
    }

    public function testDestroyBookmarkedStory()
    {
        $userId = factory(User::class, 10)
            ->create()
            ->random(1)
            ->pluck('id')
            ->first();
        factory(HackerNewsItem::class, 200)
            ->create();
        $storyIds = (new HackerNewsItem())
            ->select('id')
            ->where('type', ItemType::STORY)
            ->inRandomOrder()
            ->limit(5)
            ->pluck('id')
        ;

        foreach ($storyIds as $id) {
            $hackerNewsItemsBookmark = new HackerNewsItemsBookmark();
            $hackerNewsItemsBookmark->user_id = $userId;
            $hackerNewsItemsBookmark->hacker_news_item_id = $id;
            $hackerNewsItemsBookmark->created_at = $this->faker->dateTimeThisYear();
            $hackerNewsItemsBookmark->updated_at = $this->faker->dateTimeThisMonth();
            $hackerNewsItemsBookmark->save();
        }
        $storyId = (new HackerNewsItemsBookmark())
            ->select('hacker_news_item_id')
            ->where('user_id', $userId)
            ->inRandomOrder()
            ->limit(1)
            ->first()
            ->hacker_news_item_id;

        $bookmarkedStories = new BookmarkedStories();
        $result = $bookmarkedStories->destroyBookmarkedStory($storyId, $userId);
        $this->assertIsBool($result);
        $this->assertTrue($result);
        $this->assertDatabaseMissing('hacker_news_items_bookmarks', [
            'hacker_news_item_id' => $storyId,
            'user_id' => $userId,
        ]);
    }
}
