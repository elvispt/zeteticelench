<?php

use App\Models\Expense;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Expense::class, static function (Faker $faker) {
    $usersIdList = User::all()
                       ->pluck('id')
                       ->toArray();

    return [
        'user_id' => $faker->randomElement($usersIdList),
        'description' => $faker->realText($faker->numberBetween(10, 55)),
        'amount' => $faker->randomFloat(2, 1, 999999),
        'created_at' => $faker->dateTimeThisDecade('-1 Years'),
        'updated_at' => $faker->dateTimeThisYear(),
    ];
});
