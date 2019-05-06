<?php

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Note::class, 10)->create()->each(function (Note $note) {
            $limit = mt_rand(0, 5);
            if ($limit) {
                $tags = (new Tag())
                    ->inRandomOrder()
                    ->limit($limit)
                    ->get()
                    ->pluck('id')
                    ->toArray();
                if (!empty($tags)) {
                    $note->tags()->sync($tags);
                }
            }
        });
    }
}
