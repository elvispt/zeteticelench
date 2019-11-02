<?php

use App\Models\Account;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define( Account::class, function (Faker $faker) {
    $usersIdList = User::all()
                       ->pluck('id')
                       ->toArray();

    $updated = $faker->dateTimeThisYear('-2 Months');
    return [
        'user_id' => $faker->randomElement($usersIdList),
        'name' => $faker->randomElement(
            [$faker->colorName, $faker->realText(255)]),
        'description' => $faker->randomElement(
            [null, $faker->realText(1000)]),
        'deleted_at' => $faker->randomElement([null, $faker->dateTimeThisMonth()]),
        'created_at' => $updated,
        'updated_at' => $updated,
    ];
});
