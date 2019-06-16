<?php

use App\Models\HackerNewsItem;
use Illuminate\Database\Seeder;

class HackerNewsItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(HackerNewsItem::class, 10)->create();
    }
}
