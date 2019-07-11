<?php

namespace Tests\Feature\Controllers\HackerNews;

use App\Models\HackerNewsItem;
use App\Models\User;
use App\Repos\HackerNews\ItemType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HackerNewsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListTopStoriesFailsWithNoAuth()
    {
        $this
            ->get(route('hackernews-top'))
            ->assertStatus(302)
        ;
    }

    public function testListTopStories()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-top'))
            ->assertStatus(200)
        ;
    }

    public function testListBestStories()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-best'))
            ->assertStatus(200)
        ;
    }

    public function testListJobStories()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-jobs'))
            ->assertStatus(200)
        ;
    }

    public function testListBookmarkedStories()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-bookmark-list'))
            ->assertStatus(200)
        ;
    }

    public function testBookmarkStoryFailsWithNonExistingStoryId()
    {
        factory(HackerNewsItem::class, 10)
            ->create();
        $storyId = 879789561136543;

        $user = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first();

        $this
            ->actingAs($user)
            ->post(
                route('hackernews-bookmark-add'),
                ['story_id' => $storyId]
            )
            ->assertStatus(302)
        ;
        $this->assertDatabaseMissing('hacker_news_items_bookmarks', [
            'hacker_news_item_id' => $storyId,
            'user_id' => $user->id,
        ]);
    }

    public function testBookmarkStory()
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

        $user = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first();

        $this
            ->actingAs($user)
            ->post(
                route('hackernews-bookmark-add'),
                ['story_id' => $storyId]
            )
            ->assertStatus(200)
        ;
        $this->assertDatabaseHas('hacker_news_items_bookmarks', [
            'hacker_news_item_id' => $storyId,
            'user_id' => $user->id,
        ]);
    }

    public function testDestroyBookmarkedStoryFailsWithNonExistingStoryId()
    {
        factory(HackerNewsItem::class, 10)
            ->create();
        $storyId = 879789561136543;

        $user = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first();

        $this
            ->actingAs($user)
            ->delete(
                route('hackernews-bookmark-destroy'),
                ['story_id' => $storyId]
            )
            ->assertStatus(302)
        ;
    }

    public function testDestroyBookmarkedStory()
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

        $user = factory(User::class, 10)
            ->create()
            ->random(1)
            ->first();

        $this
            ->actingAs($user)
            ->delete(
                route('hackernews-bookmark-destroy'),
                ['story_id' => $storyId]
            )
            ->assertStatus(200)
        ;
        $this->assertDatabaseMissing('hacker_news_items_bookmarks', [
            'hacker_news_item_id' => $storyId,
            'user_id' => $user->id,
        ]);
    }

    public function testShowStoryFailsWithNonExistingStoryId()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-item', ['id' => 123]))
            ->assertStatus(404)
        ;
    }

    public function testShowStory()
    {
        $user = factory(User::class)
            ->create();
        factory(HackerNewsItem::class, 100)
            ->create();

        $id = (new HackerNewsItem())
            ->select('id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first()
        ;

        $this
            ->actingAs($user)
            ->get(route('hackernews-item', ['id' => $id]))
            ->assertStatus(200)
        ;
    }
}
