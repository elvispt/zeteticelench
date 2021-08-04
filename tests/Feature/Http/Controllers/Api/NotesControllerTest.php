<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListNotesFailsWithNoAuth()
    {
        $this
            ->get(route('apiNotesList'))
            ->assertStatus(302)
        ;
    }

    public function testListNotes()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $this
            ->actingAs($user)
            ->get(route('apiNotesList'))
            ->assertStatus(200)
            ->assertJsonStructure(['data' => []])
        ;
    }

    public function testShowNoteFailsWithNonExistingNoteId()
    {
        $user = User::factory()
            ->create();

        $this
            ->actingAs($user)
            ->get(route('apiNote', ['noteId' => 890776454567]))
            ->assertStatus(404)
        ;
    }

    public function testShowNote()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $id = (new Note())
            ->select('id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first();

        $this
            ->actingAs($user)
            ->get(route('apiNote', ['noteId' => $id]))
            ->assertStatus(200)
            ->assertJsonStructure(['data' => []])
        ;
    }

    public function testUpdateNoteFailsWithNoNoteDataSent()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $id = (new Note())
            ->select('id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first();

        $this
            ->actingAs($user)
            ->put(route('apiNoteUpdate', ['noteId' => $id]))
            ->assertStatus(302)
        ;
    }

    public function testUpdateNoteFailsWithInvalidNoteId()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $title = 'new title ' . Str::random();
        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->put(
                route('apiNoteUpdate', ['noteId' => 879167382]),
                [
                    'title' => $title,
                    'body' => $body,
                ]
            )
            ->assertStatus(404)
        ;
    }

    public function testUpdateNoteWithRequiredData()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $id = (new Note())
            ->select('id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first();

        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->put(
                route('apiNoteUpdate', ['noteId' => $id]),
                ['body' => $body]
            )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'success' => true,
                    'id' => $id,
                ],
            ])
        ;
        $this->assertDatabaseHas('notes', [
            'id' => $id,
            'body' => $body,
        ]);
    }

    public function testUpdateNoteWithAllNoteData()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $id = (new Note())
            ->select('id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first();


        $tags = Tag::factory()
            ->count(50)
            ->create([
                'user_id' => $user->id,
            ])
            ->pluck('id')
            ->random(2)
            ->toArray();

        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->put(
                route('apiNoteUpdate', ['noteId' => $id]),
                [
                    'body' => $body,
                    'tags' => $tags,
                ]
            )
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'success' => true,
                    'id' => $id,
                ],
            ])
        ;
        $this->assertDatabaseHas('notes', [
            'id' => $id,
            'body' => $body,
        ]);
        foreach ($tags as $tagId) {
            $this->assertDatabaseHas('note_tag', [
                'note_id' => $id,
                'tag_id' => $tagId,
            ]);
        }
    }

    public function testAddNoteFailsWithNoNoteDataSent()
    {
        $user = User::factory()
            ->create();

        $this
            ->actingAs($user)
            ->post(route('apiNoteAdd'))
            ->assertStatus(302)
        ;
    }

    public function testAddNoteWithRequiredData()
    {
        $user = User::factory()
            ->create();

        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->post(
                route('apiNoteAdd'),
                [
                    'body' => $body,
                ]
            )
            ->assertStatus(200)
            ->assertJsonFragment(['success' => true])
            ->assertJsonStructure(['data' => ['success', 'id']])
        ;
        $this->assertDatabaseHas('notes', [
            'body' => $body,
        ]);
    }

    public function testAddNoteWithAllNoteData()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);
        $tags = Tag::factory()
            ->count(50)
            ->create([
                'user_id' => $user->id,
            ])
            ->pluck('id')
            ->random(2)
            ->toArray();

        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->post(
                route('apiNoteAdd'),
                [
                    'body' => $body,
                    'tags' => $tags,
                ]
            )
            ->assertStatus(200)
            ->assertJsonFragment(['success' => true])
            ->assertJsonStructure(['data' => ['success', 'id']])
        ;
        $id = (new Note())
            ->select('id')
            ->orderBy('id', 'DESC')
            ->first()
            ->id
        ;
        $this->assertDatabaseHas('notes', [
            'body' => $body,
        ]);
        foreach ($tags as $tagId) {
            $this->assertDatabaseHas('note_tag', [
                'note_id' => $id,
                'tag_id' => $tagId,
            ]);
        }
    }

    public function testDestroyNoteFailsWithInvalidNoteId()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $this
            ->actingAs($user)
            ->delete(route('apiNoteDestroy', ['noteId' => 876567456]))
            ->assertStatus(404)
        ;
    }

    public function testDestroyNote()
    {
        $user = User::factory()
            ->create();
        Note::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $id = (new Note())
            ->select('id')
            ->inRandomOrder()
            ->first()
            ->id;
        ;

        $this
            ->actingAs($user)
            ->delete(route('apiNoteDestroy', ['noteId' => $id]))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'success' => true,
                    'id' => $id,
                ],
            ])
        ;
        $this->assertSoftDeleted('notes', [
            'id' => $id,
        ]);
    }

    public function testTagListingWithTagsOnDatabase()
    {
        $user = User::factory()
            ->create();
        Tag::factory()
            ->count(10)
            ->create([
                'user_id' => $user->id,
            ]);

        $this
            ->actingAs($user)
            ->get(route('apiNotesTagsList'))
            ->assertStatus(200)
            ->assertJson(['data' => []])
        ;
    }

    public function testTagListingWithNoTagsOnDatabase()
    {
        $user = User::factory()
            ->create();

        $this
            ->actingAs($user)
            ->get(route('apiNotesTagsList'))
            ->assertStatus(200)
            ->assertJson(['data' => []])
        ;
    }

    public function testTagAddFailsWithNoData()
    {
        $user = User::factory()
            ->create();

        $this
            ->actingAs($user)
            ->post(route('apiNotesTagAdd'))
            ->assertStatus(302)
        ;
    }

    public function testTagAdd()
    {
        $user = User::factory()
            ->create();

        $tag = "TagName";
        $finalTagName = Str::lower($tag);
        $data = ['tag' => $tag];

        $this
            ->actingAs($user)
            ->post(route('apiNotesTagAdd', $data))
            ->assertStatus(200)
            ->assertJsonFragment(['success' => true])
            ->assertJsonStructure(['data' => ['success', 'id']])
        ;
        $this->assertDatabaseHas('tags', [
            'tag' => $finalTagName,
        ]);
    }

    public function testTagAddFailWithExistingTag()
    {
        $user = User::factory()
            ->create();
        $tag = Tag::factory()
            ->count(3)
            ->create()
            ->random(1)
            ->first()
            ->tag;

        $data = ['tag' => $tag];

        $this
            ->actingAs($user)
            ->post(route('apiNotesTagAdd', $data))
            ->assertStatus(302)
        ;
    }
}
