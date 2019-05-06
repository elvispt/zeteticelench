<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'tag' => $faker->unique()->word,
        'created_at' => $faker->dateTimeThisDecade('-1 Year'),
        'updated_at' => $faker->dateTimeThisYear(),
    ];
});
