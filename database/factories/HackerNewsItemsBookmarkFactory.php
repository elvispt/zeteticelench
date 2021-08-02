<?php

namespace Database\Factories;

use App\Models\HackerNewsItemsBookmark;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class HackerNewsItemsBookmarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HackerNewsItemsBookmark::class;

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
            'hacker_news_item_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomElement($usersIdList),
            'created_at' => $this->faker->dateTimeThisDecade('-2 Years'),
            'updated_at' => $this->faker->dateTimeThisYear('-2 Months'),
        ];
    }
}
