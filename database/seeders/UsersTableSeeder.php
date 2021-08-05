<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()
                    ->create([
                        'name' => "Seeded User",
                        'email' => 'dev@dev.dev',
                        'updated_at' => Date::now(),
                        'created_at' => Date::now(),
                    ]);

        Note::factory()
            ->count(10)
            ->for($user)
            ->hasAttached(
                Tag::factory()
                    ->count(3)
                    ->state(function (array $attributes, Note $note) use ($user) {
                        return [
                            'user_id' => $user->id,
                        ];
                    })
            )
            ->create()
        ;

        for ($i = 0; $i < 5; $i++) {
            $user = User::factory()->create();

            Note::factory()
                ->count(mt_rand(1, 5))
                ->for($user)
                ->hasAttached(
                    Tag::factory()
                       ->count(mt_rand(1, 5))
                       ->state(function (array $attributes, Note $note) use ($user) {
                           return [
                               'user_id' => $user->id,
                           ];
                       })
                )
                ->create()
            ;
        }
    }
}
