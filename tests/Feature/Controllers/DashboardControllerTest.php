<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowDashboardFailsWithNoAuth()
    {
        $this
            ->get('/')
            ->assertStatus(302)
        ;
    }

    public function testShowDashboard()
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
