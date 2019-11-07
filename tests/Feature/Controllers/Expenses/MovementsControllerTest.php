<?php

namespace Tests\Feature\Controllers\HackerNews;

use App\Models\Account;
use App\Models\Movement;
use App\Models\User;
use App\Repos\Expenses\Movements;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovementsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListMovementsWithNoAuth()
    {
        $this
            ->get(route('movements'))
            ->assertStatus(302)
        ;
    }

    public function testListMovementsWithNoAccounts()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('movements'))
            ->assertStatus(200)
        ;
    }

    public function testListMovementsWithNoMovementsOnAccount()
    {
        $user = factory(User::class)
            ->create();

        factory(Account::class, 10)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('movements'))
            ->assertStatus(200)
        ;
    }

    public function testListMovements()
    {
        $user = factory(User::class)
            ->create();

        factory(Account::class, 10)
            ->create();
        factory(Movement::class, 100)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('movements'))
            ->assertStatus(200)
        ;
    }

    public function testShowCreateMovementPageFailsWithNoAuth()
    {
        $this->get(route('movementsCreate'))
             ->assertStatus(302);
    }

    public function testShowCreateMovementPage()
    {
        $user = factory(User::class)
            ->create();

        $this->actingAs($user)
            ->get(route('movementsCreate'))
            ->assertStatus(200);
    }

    public function testCreateMovementFailsWithNoAuth()
    {
        $this->post(route('movementsAdd'))
             ->assertStatus(302);
    }

    public function testCreateMovementFailsWithNoDataSent()
    {
        $user = factory(User::class)
            ->create();

        $this->actingAs($user)
             ->post(route('movementsAdd'))
             ->assertStatus(302);
    }

    public function testCreateMovementFailsWithInvalidDate()
    {
        $user = factory(User::class)
            ->create();

        $this->actingAs($user)
             ->post(
                 route('movementsAdd'),
                 [
                     'date' => '1000-13-89',
                     'time' => '14:39',
                     'amount' => 14.87,
                     'description' => 'Description feature test',
                     'credit-debit' => Movements::DEBIT,
                 ]
             )
             ->assertStatus(302);
    }

    public function testCreateMovementFailsWithInvalidTime()
    {
        $user = factory(User::class)
            ->create();

        $this->actingAs($user)
             ->post(
                 route('movementsAdd'),
                 [
                     'date' => '2013-05-06',
                     'time' => '96:63',
                     'amount' => 14.87,
                     'description' => 'Description feature test',
                     'credit-debit' => Movements::DEBIT,
                 ]
             )
             ->assertStatus(302);
    }

    public function testCreateMovementFailsWithInvalidAmount()
    {
        $user = factory(User::class)
            ->create();

        $this->actingAs($user)
             ->post(
                 route('movementsAdd'),
                 [
                     'date' => '2013-05-06',
                     'time' => '14:01',
                     'amount' => 'jah',
                     'description' => 'Description feature test',
                     'credit-debit' => Movements::DEBIT,
                 ]
             )
             ->assertStatus(302);
    }

    public function testCreateMovementFailsWithInvalidCreditDebitOption()
    {
        $user = factory(User::class)
            ->create();

        $this->actingAs($user)
             ->post(
                 route('movementsAdd'),
                 [
                     'date' => '2013-05-06',
                     'time' => '14:01',
                     'amount' => 34.98,
                     'description' => 'Description feature test',
                     'credit-debit' => 'hjbkfadsq',
                 ]
             )
             ->assertStatus(302);
    }

    public function testCreateMovement()
    {
        $user = factory(User::class)
            ->create();
        $account = factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);

        $date = '2016-06-11';
        $time = '14:01';
        $amount = 34.98;
        $description = 'A testing description';
        $this->actingAs($user)
             ->post(
                 route('movementsAdd'),
                 [
                     'date' => $date,
                     'time' => $time,
                     'amount' => $amount,
                     'description' => $description,
                     'credit-debit' => Movements::DEBIT,
                 ]
             )
             ->assertRedirect(route('movements'));

        $this->assertDatabaseHas('movements', [
            'account_id' => $account->id,
            'amount' => -$amount,
            'description' => $description,
            'amount_date' => "$date $time",
        ]);
    }
}
