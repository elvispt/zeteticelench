<?php

use App\Models\Note;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;


$usersIdList = User::all()
    ->pluck('id')
    ->toArray();

/**
 * @var Factory $factory
 */
$factory->define(Note::class, function (Faker $faker) {
    $usersIdList = User::all()
                       ->pluck('id')
                       ->toArray();

    return [
        'user_id' => $faker->randomElement($usersIdList),
        'body' => $faker->realText(500),
        'deleted_at' => $faker->randomElement([null, $faker->dateTimeThisMonth()]),
        'created_at' => $faker->dateTimeThisDecade('-2 Years'),
        'updated_at' => $faker->dateTimeThisYear('-2 Months'),
    ];
});
