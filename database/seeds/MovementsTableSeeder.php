<?php

use App\Models\Movement;
use Illuminate\Database\Seeder;

class MovementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Movement::class, 10)->create();
    }
}
