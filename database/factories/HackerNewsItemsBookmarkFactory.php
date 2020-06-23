<?php

use App\Models\HackerNewsItemsBookmark;
use App\Models\User;
use Illuminate\Database\Eloquent\Factory;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/**
 * @var Factory $factory
 */
$factory->define(HackerNewsItemsBookmark::class, function (Faker $faker) {
    $usersIdList = User::all()
                       ->pluck('id')
                       ->toArray();

    return [
        'hacker_news_item_id' => $faker->randomNumber(),
        'user_id' => $faker->randomElement($usersIdList),
        'created_at' => $faker->dateTimeThisDecade('-2 Years'),
        'updated_at' => $faker->dateTimeThisYear('-2 Months'),
    ];
});
