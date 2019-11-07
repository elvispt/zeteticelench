<?php

use App\Models\Account;
use App\Models\Movement;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define( Movement::class, function (Faker $faker) {
    $accountsIdList = Account::all()
                       ->pluck('id')
                       ->toArray();

    $updated = $faker->dateTimeThisYear('-2 Months');
    return [
        'account_id' => $faker->randomElement($accountsIdList),
        'amount' => $faker->randomFloat(2, -9999999.99, 9999999.99),
        'description' => $faker->randomElement(
            [$faker->realText(1000), null]),
        'amount_date' => $faker->dateTimeThisYear(),
        'created_at' => $updated,
        'updated_at' => $updated,
    ];
});
