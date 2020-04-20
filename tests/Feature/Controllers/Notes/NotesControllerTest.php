<?php

namespace Tests\Feature\Controllers\Notes;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowNotesPageFailsWithNoAuth()
    {
        $this
            ->get(route('notes'))
            ->assertStatus(302)
        ;
    }

    public function testShowNotesPage()
    {
        $user = factory(User::class)
            ->create();

        factory(Note::class, 10)
            ->create([
                'user_id' => $user->id,
            ]);

        $this
            ->actingAs($user)
            ->get(route('notes'))
            ->assertStatus(200)
        ;
    }
}
