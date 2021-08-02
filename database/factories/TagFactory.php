<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $usersIdList = User::all()
                       ->pluck('id')
                       ->toArray();

        return [
            'user_id' => $this->faker->randomElement($usersIdList),
            'tag' => $this->faker->unique()->word . \Illuminate\Support\Str::random(5),
            'created_at' => $this->faker->dateTimeThisDecade('-1 Year'),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
