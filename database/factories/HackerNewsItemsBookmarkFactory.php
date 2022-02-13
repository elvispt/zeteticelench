<?php

namespace Database\Factories;

use App\Models\HackerNewsItemsBookmark;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $createdAt = $this->faker->dateTimeThisDecade('-2 Years');

        return [
            'hacker_news_item_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomElement($usersIdList),
            'created_at' => $createdAt,
            'updated_at' => $this->faker->randomElement([
                $createdAt,
                $this->faker->dateTimeThisYear(),
            ]),
        ];
    }
}
