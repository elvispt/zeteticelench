<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testShowUserListingFailsWithNoAuth()
    {
        $this
            ->get(route('users'))
            ->assertStatus(302)
        ;
    }

    public function testShowUserListing()
    {
        $user = User::factory()
            ->create();

        User::factory()
            ->count(10)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('users'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'currentUserId',
            ])
        ;
    }

    public function testUserUpdateFailsWithNoUserDataSent()
    {
        $user = User::factory()
            ->create();

        User::factory()
            ->count(10)
            ->create();

        $this
            ->actingAs($user)
            ->put(route('usersUpdate'))
            ->assertStatus(302)
        ;
    }

    public function testUserUpdateFailsWithInvalidUserId()
    {
        $user = User::factory()
            ->create();

        User::factory()
            ->count(10)
            ->create();

        $userId = 2148972168794;
        $name = $this->faker->name;
        $this
            ->actingAs($user)
            ->put(
                route('usersUpdate'),
                [
                    'id' => $userId,
                    'name' => $name,
                ]
            )
            ->assertStatus(302)
        ;
    }

    public function testUserUpdateWithRequiredData()
    {
        $user = User::factory()
            ->create();

        User::factory()
            ->count(10)
            ->create();

        $id = (new User())
            ->select('id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first();

        $name = $this->faker->name;
        $this
            ->actingAs($user)
            ->put(
                route('usersUpdate'),
                [
                    'id' => $id,
                    'name' => $name,
                ]
            )
            ->assertJson([
                'data' => [
                    'id' => $id,
                    'success' => true,
                ],
            ])
        ;
        $this->assertDatabaseHas('users', [
            'id' => $id,
            'name' => $name,
        ]);
    }

    public function testAddUserFailsWithNoUserDataSent()
    {
        $user = User::factory()
            ->create();

        $data = [];
        $this
            ->actingAs($user)
            ->post(route('usersCreate'), $data)
            ->assertStatus(302)
        ;
    }

    public function testAddUserWithRequiredData()
    {
        $user = User::factory()
            ->create();

        $name = $this->faker->name;
        $email = $this->faker->email;
        $password = $this->faker->password(12, 100);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];
        $this
            ->actingAs($user)
            ->post(route('usersCreate'), $data)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'success',
                ],
            ])
        ;

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function testDestroyUserFailsWithInvalidUserId()
    {
        $user = User::factory()
            ->create();

        $id = 99999865321;
        $this
            ->actingAs($user)
            ->delete(route('usersDestroy'), ['id' => $id])
            ->assertStatus(302)
        ;
    }

    public function testDestroyUser()
    {
        $user = User::factory()
            ->create();

        User::factory()
            ->count(20)
            ->create();

        $id = (new User())
            ->select('id')
            ->inRandomOrder()
            ->first()
            ->id
        ;

        $this
            ->actingAs($user)
            ->delete(route('usersDestroy'), ['id' => $id])
            ->assertJson([
                'data' => [
                    'id' => $id,
                    'success' => true,
                ],
            ])
        ;
        $this->assertDatabaseMissing('notes', [
            'id' => $id,
        ]);
    }

    public function testDestroyUserIncludingNotes()
    {
        $user = User::factory()
            ->create();

        User::factory()
            ->count(20)
            ->create();

        $id = (new User())
            ->select('id')
            ->inRandomOrder()
            ->first()
            ->id
        ;
        $tagIds = Tag::factory()
            ->count(20)
            ->create()
            ->random(mt_rand(2, 7))
            ->pluck('id')
            ->toArray()
        ;

        Note::factory()
            ->count(20)
            ->create();

        Note::factory()
            ->count(20)
            ->has(Tag::factory()->count(5))
            ->create();

        $this
            ->actingAs($user)
            ->delete(route('usersDestroy'), ['id' => $id])
            ->assertJson([
                'data' => [
                  'id' => $id,
                  'success' => true,
                ],
            ])
        ;
        $this->assertDatabaseMissing('notes', [
            'user_id' => $id,
        ]);
    }
}
