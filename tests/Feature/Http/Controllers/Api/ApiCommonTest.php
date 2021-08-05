<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCommonTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeCommonApiRequestsWithNoAuth()
    {
        $this
            ->get(route('apiInspire'))
            ->assertStatus(302)
        ;

        $this
            ->get(route('apiSystemInfo'))
            ->assertStatus(302)
        ;
    }

    public function testMakeCommonApiRequests()
    {
        $user = User::factory()
            ->create();

        $this
            ->actingAs($user)
            ->get(route('apiInspire'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ])
        ;

        $this
            ->actingAs($user)
            ->get(route('apiSystemInfo'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ])
        ;
    }
}
