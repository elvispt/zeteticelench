<?php

use App\Models\Tag;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define(Tag::class, function (Faker $faker) {
    $usersIdList = User::all()
                       ->pluck('id')
                       ->toArray();

    return [
        'user_id' => $faker->randomElement($usersIdList),
        'tag' => $faker->unique()->word . \Illuminate\Support\Str::random(5),
        'created_at' => $faker->dateTimeThisDecade('-1 Year'),
        'updated_at' => $faker->dateTimeThisYear(),
    ];
});
