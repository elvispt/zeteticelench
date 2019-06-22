<?php

namespace Tests\Feature;

use App\Models\HackerNewsItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HackerNewsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testTopWithNoAuth()
    {
        $this
            ->get(route('hackernews-top'))
            ->assertStatus(302)
        ;
    }

    public function testTop()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-top'))
            ->assertStatus(200)
        ;
    }

    public function testBest()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-best'))
            ->assertStatus(200)
        ;
    }

    public function testJobs()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-jobs'))
            ->assertStatus(200)
        ;
    }

    public function testItemWithNonExistingItem()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('hackernews-item', ['id' => 123]))
            ->assertStatus(404)
        ;
    }

    public function testItem()
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
