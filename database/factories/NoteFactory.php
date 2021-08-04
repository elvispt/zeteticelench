<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

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

        $body = "# ";
        $body .= $this->faker->sentence();
        $body .= "\r\n\r\n";
        $body .= $this->faker->realText(500);

        $code = "# ";
        $code .= $this->faker->sentence();
        $code .= "\r\n\r\n";
        $code .= <<<'EOT'
            namespace Database\Factories;

            use App\Models\Note;
            use App\Models\User;
            use Faker\Generator as Faker;
            use Illuminate\Database\Eloquent\Factories\Factory;

            class NoteFactory extends Factory
            {
                /**
                 * The name of the factory's corresponding model.
                 *
                 * @var string
                 */
                protected $model = Note::class;

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

                    $body = "# ";
                    $body .= $this->faker->sentence();
                    $body .= "\r\n\r\n";
                    $body .= $this->faker->realText(500);

                    $code = "
                        ```php

                        ```
                    ";

                    return [
                        'user_id' => $this->faker->randomElement($usersIdList),
                        'body' => $body,
                        'deleted_at' => $this->faker->randomElement([null, $this->faker->dateTimeThisMonth()]),
                        'created_at' => $this->faker->dateTimeThisDecade('-2 Years'),
                        'updated_at' => $this->faker->dateTimeThisYear('-2 Months'),
                    ];
                }
            }
EOT;
        $code .= "\r\n\r\n";
        $code .= $this->faker->realText(100);

        return [
            'user_id' => $this->faker->randomElement($usersIdList),
            'body' => $this->faker->randomElement([$body, $code]),
            'deleted_at' => $this->faker->optional(0.8)->randomElement([null, $this->faker->dateTimeThisMonth()]),
            'created_at' => $this->faker->dateTimeThisDecade('-2 Years'),
            'updated_at' => $this->faker->dateTimeThisYear('-2 Months'),
        ];
    }
}
