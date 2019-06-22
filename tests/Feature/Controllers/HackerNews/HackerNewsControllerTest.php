<?php

namespace Tests\Feature\Controllers\HackerNews;

use App\Models\HackerNewsItem;
use App\Models\User;
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
