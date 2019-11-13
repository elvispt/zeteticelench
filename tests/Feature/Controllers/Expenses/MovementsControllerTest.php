<?php

namespace Tests\Feature\Controllers\HackerNews;

use App\Models\Account;
use App\Models\Movement;
use App\Models\Tag;
use App\Models\User;
use App\Repos\Expenses\Movements;
use App\Repos\Tags\TagType;
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

        factory(Account::class, 3)
            ->create([
                'deleted_at' => null,
            ]);
        $movements = factory(Movement::class, 30)
            ->create();
        $tags = factory(Tag::class, 20)
            ->create();
        $expenseTags = $tags->where('type', TagType::EXPENSE);

        $movements
            ->random(10)
            ->each(static function (Movement $movement) use ($expenseTags) {
                $tagIds = $expenseTags
                    ->random(mt_rand(1, $expenseTags->count()))
                    ->pluck('id')
                    ->toArray();
                $movement->tags()->sync($tagIds);
            });

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

    public function testCreateMovementFailsWithInvalidTags()
    {
        $user = factory(User::class)
            ->create();

        $this->actingAs($user)
             ->post(
                 route('movementsAdd'),
                 [
                     'date' => '2013-05-06',
                     'time' => '14:01',
                     'amount' => 95.32,
                     'description' => 'Description feature test',
                     'credit-debit' => Movements::DEBIT,
                     'tags' => [9999, 2123]
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
        $tags = factory(Tag::class, 50)
            ->create()
            ->where('type', TagType::EXPENSE)
            ->pluck('id')
            ->random(2)
            ->toArray()
        ;

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
                     'tags' => $tags,
                 ]
             )
             ->assertRedirect(route('movements'));

        $this->assertDatabaseHas('movements', [
            'account_id' => $account->id,
            'amount' => -$amount,
            'description' => $description,
            'amount_date' => "$date $time",
        ]);
        $id = (new Movement())
            ->select('id')
            ->where('account_id', $account->id)
            ->orderBy('id', 'DESC')
            ->first()
            ->pluck('id');

        foreach ($tags as $tagId) {
            $this->assertDatabaseHas('movement_tag', [
                'movement_id' => $id,
                'tag_id' => $tagId,
            ]);
        }
    }

    public function testShowEditMovementPageFailsWithNoAuth()
    {
        factory(User::class)
            ->create();
        factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);
        $movement = factory(Movement::class)
            ->create();
        $this->get(route('movementsEdit', ['id' => $movement->id]))
             ->assertStatus(302);
    }

    public function testShowEditMovementPage()
    {
        $user = factory(User::class)
            ->create();
        factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);
        $movement = factory(Movement::class)
            ->create();

        $this->actingAs($user)
             ->get(route('movementsEdit', ['id' => $movement->id]))
             ->assertStatus(200);
    }

    public function testUpdateMovementFailsWithNoAuth()
    {
        $this->put(route('movementsUpdate'))
             ->assertStatus(302);
    }

    public function testUpdateMovementFailsWithNoDataSent()
    {
        $user = factory(User::class)
            ->create();

        $this->actingAs($user)
             ->put(route('movementsUpdate'))
             ->assertStatus(302);
    }

    public function testUpdateMovementFailsWithInvalidId()
    {
        $user = factory(User::class)
            ->create();
        factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);
        factory(Movement::class)
            ->create();

        $this->actingAs($user)
             ->put(
                 route('movementsUpdate'),
                 [
                     'id' => 984641,
                     'date' => '2016-11-06',
                     'time' => '14:39',
                     'amount' => 14.87,
                     'description' => 'Description feature test',
                 ]
             )
             ->assertStatus(302);
    }

    public function testUpdateMovementFailsWithInvalidDate()
    {
        $user = factory(User::class)
            ->create();
        factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);
        $movement = factory(Movement::class)
            ->create();

        $this->actingAs($user)
             ->put(
                 route('movementsUpdate'),
                 [
                     'id' => $movement->id,
                     'date' => '1000-13-89',
                     'time' => '14:39',
                     'amount' => 14.87,
                     'description' => 'Description feature test',
                 ]
             )
             ->assertStatus(302);
    }

    public function testUpdateMovementFailsWithInvalidTime()
    {
        $user = factory(User::class)
            ->create();
        factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);
        $movement = factory(Movement::class)
            ->create();

        $this->actingAs($user)
             ->put(
                 route('movementsUpdate'),
                 [
                     'id' => $movement->id,
                     'date' => '2013-05-06',
                     'time' => '96:63',
                     'amount' => 14.87,
                     'description' => 'Description feature test',
                 ]
             )
             ->assertStatus(302);
    }

    public function testUpdateMovementFailsWithInvalidAmount()
    {
        $user = factory(User::class)
            ->create();
        factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);
        $movement = factory(Movement::class)
            ->create();

        $this->actingAs($user)
             ->put(
                 route('movementsUpdate'),
                 [
                     'id' => $movement->id,
                     'date' => '2013-05-06',
                     'time' => '14:01',
                     'amount' => 'jah',
                     'description' => 'Description feature test',
                 ]
             )
             ->assertStatus(302);
    }

    public function testUpdateMovementFailsWithInvalidTags()
    {
        $user = factory(User::class)
            ->create();
        factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);
        $movement = factory(Movement::class)
            ->create();

        $this->actingAs($user)
             ->put(
                 route('movementsUpdate'),
                 [
                     'id' => $movement->id,
                     'date' => '2013-05-06',
                     'time' => '14:01',
                     'amount' => 95.32,
                     'description' => 'Description feature test',
                     'tags' => [9999, 2123]
                 ]
             )
             ->assertStatus(302);
    }

    public function testUpdateMovement()
    {
        $user = factory(User::class)
            ->create();
        $account = factory(Account::class)
            ->create([
                'deleted_at' => null,
            ]);
        $movement = factory(Movement::class)
            ->create();
        $tags = factory(Tag::class, 50)
            ->create()
            ->where('type', TagType::EXPENSE)
            ->pluck('id')
            ->random(2)
            ->toArray()
        ;

        $id = $movement->id;
        $date = '2016-06-11';
        $time = '14:01';
        $amount = 34.98;
        $description = 'A testing description';
        $this->actingAs($user)
             ->put(
                 route('movementsUpdate'),
                 [
                     'id' => $id,
                     'date' => $date,
                     'time' => $time,
                     'amount' => $amount,
                     'description' => $description,
                     'tags' => $tags,
                 ]
             )
             ->assertRedirect(route('movements'));

        $this->assertDatabaseHas('movements', [
            'id' => $id,
            'account_id' => $account->id,
            'amount' => $amount,
            'description' => $description,
            'amount_date' => "$date $time",
        ]);

        foreach ($tags as $tagId) {
            $this->assertDatabaseHas('movement_tag', [
                'movement_id' => $id,
                'tag_id' => $tagId,
            ]);
        }
    }
}