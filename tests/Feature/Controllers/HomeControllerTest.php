<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexWithNoAuth()
    {
        $this
            ->get('/')
            ->assertStatus(302)
        ;
    }

    public function testIndexWithAuth()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get('/')
            ->assertStatus(200)
        ;
    }
}
