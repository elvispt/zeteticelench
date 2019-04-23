<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Note;
use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(50),
        'body' => $faker->realText(500),
        'deleted_at' => $faker->randomElement([null, $faker->dateTimeThisMonth()]),
        'created_at' => $faker->dateTimeThisDecade('-2 Years'),
        'updated_at' => $faker->dateTimeThisYear('-2 Months'),
    ];
});
