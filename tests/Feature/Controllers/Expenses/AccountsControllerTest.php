<?php

namespace Tests\Feature\Controllers\HackerNews;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListAccountsWithNoAuth()
    {
        $this
            ->get(route('expensesAccounts'))
            ->assertStatus(302)
        ;
    }

    public function testListAccountsWithNoAccounts()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('expensesAccounts'))
            ->assertStatus(200)
        ;
    }

    public function testListAccounts()
    {
        $user = factory(User::class)
            ->create();

        factory(Account::class, 10)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('expensesAccounts'))
            ->assertStatus(200)
        ;
    }
}
