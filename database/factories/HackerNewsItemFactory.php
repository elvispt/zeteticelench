<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\HackerNewsItem;
use App\Repos\HackerNews\ItemType;
use Faker\Generator as Faker;

$factory->define(HackerNewsItem::class, function (Faker $faker) {
    $kids = [];
    for ($i = 0; $i <= $faker->numberBetween(0, 100); $i++) {
        $kids[] = $faker->numberBetween();
    }
    return [
        'id' => $faker
            ->unique()
            ->numberBetween(1000, 9999999),
        'type' => $faker->randomElement(ItemType::all()),
        'parent_id' => $faker->randomElement([null, $faker->numberBetween()]),
        'by' => $faker->randomElement([null, $faker->userName]),
        'score' => $faker->numberBetween(0, 2000),
        'descendants' => $faker->numberBetween(0, 500),
        'title' => $faker->realText(),
        'url' => $faker->url,
        'kids' => \GuzzleHttp\json_encode($kids),
        'deleted_at' => $faker->randomElement([null, $faker->dateTimeThisMonth]),
        'updated_at' => $faker->randomElement([null, $faker->dateTimeThisYear]),
        'created_at' => $faker->dateTimeThisDecade,
    ];
});
