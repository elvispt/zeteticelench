<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCommonTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeCommonApiRequestsWithNoAuth()
    {
        $this
            ->get('/api/inspire')
            ->assertStatus(302)
        ;

        $this
            ->get('/api/next-holidays')
            ->assertStatus(302)
        ;

        $this
            ->get('/api/system-info')
            ->assertStatus(302)
        ;
    }

    public function testMakeCommonApiRequests()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get('/api/inspire')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ])
        ;

        $this
            ->actingAs($user)
            ->get('/api/next-holidays')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ])
        ;

        $this
            ->actingAs($user)
            ->get('/api/system-info')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ])
        ;
    }
}
