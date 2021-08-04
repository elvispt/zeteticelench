<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\HackerNewsItemsBookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HackerNewsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testBookmarksListWithNoAuth()
    {
        $this
            ->get(route('hackernews-bookmark-list'))
            ->assertStatus(302)
        ;
    }

    public function testBookmarksList()
    {
        $user = User::factory()
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-bookmark-list'))
            ->assertStatus(200)
            ->assertJsonStructure(['data' => []])
        ;
    }


    public function testAddBookmarkFailsWithNoAuth()
    {
        $id = 23551983;
        $this
            ->post(route('hackernews-bookmark-add', ['postId' => $id]))
            ->assertStatus(302)
        ;
    }

    public function testAddBookmark()
    {
        $user = User::factory()
            ->create();

        $id = 23551983;
        $this
            ->actingAs($user)
            ->post(route('hackernews-bookmark-add', ['postId' => $id]))
            ->assertStatus(200)
            ->assertJsonFragment([
                'postId' => "$id",
                'success' => true,
            ])
        ;

        $this->assertDatabaseHas('hacker_news_items_bookmarks', [
            'user_id' => $user->id,
            'hacker_news_item_id' => $id,
        ]);
    }

    public function testDestroyBookmarkFailsWithNoAuth()
    {
        $id = 9999999999;
        $this
            ->delete(route('hackernews-bookmark-destroy', ['postId' => $id]))
            ->assertStatus(302)
        ;
    }

    public function testDestroyBookmark()
    {
        $user = User::factory()
            ->create();
        $item = HackerNewsItemsBookmark::factory()
            ->create();

        $this
            ->actingAs($user)
            ->delete(route('hackernews-bookmark-destroy', ['postId' => $item->hacker_news_item_id]))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    "id" => $user->id,
                    "postId" => $item->hacker_news_item_id,
                    "success" => true,
                ],
            ])
        ;

        $this->assertDatabaseMissing('hacker_news_items_bookmarks', [
            'id' => $item->id,
            'user_id' => $user->id,
            'hacker_news_item_id' => $item->hacker_news_item_id,
        ]);
    }
}
