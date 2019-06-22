<?php

namespace Tests\Feature\Controllers\Notes;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexWithNoAuth()
    {
        $this
            ->get(route('notes'))
            ->assertStatus(302)
        ;
    }

    public function testIndex()
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

    public function testEditFailsWithNonExistingNoteId()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('notesEdit', ['noteId' => 98675645]))
            ->assertStatus(404)
        ;
    }

    public function testEdit()
    {
        $user = factory(User::class)
            ->create();
        factory(Note::class, 10)
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
            ->get(route('notesEdit', ['noteId' => $id]))
            ->assertStatus(200)
        ;
    }

    public function testUpdateFailsWithNoNoteDataSent()
    {
        $user = factory(User::class)
            ->create();
        factory(Note::class, 10)
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
            ->put(route('notesUpdate', ['noteId' => $id]))
            ->assertStatus(302)
        ;
    }

    public function testUpdateFailsWithInvalidNoteId()
    {
        $user = factory(User::class)
            ->create();
        factory(Note::class, 10)
            ->create([
                'user_id' => $user->id,
            ]);
        $title = 'new title ' . Str::random();
        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->put(
                route('notesUpdate', ['noteId' => 879167382]),
                [
                    'title' => $title,
                    'body' => $body,
                ]
            )
            ->assertStatus(404)
        ;
    }

    public function testUpdateWithRequiredData()
    {
        $user = factory(User::class)
            ->create();
        factory(Note::class, 10)
            ->create([
                'user_id' => $user->id,
            ]);
        $id = (new Note())
            ->select('id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first();

        $title = 'new title ' . Str::random();
        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->put(
                route('notesUpdate', ['noteId' => $id]),
                [
                    'title' => $title,
                    'body' => $body,
                ]
            )
            ->assertRedirect(route('notesEdit', ['noteId' => $id]))
        ;
        $this->assertDatabaseHas('notes', [
            'id' => $id,
            'title' => $title,
            'body' => $body,
        ]);
    }

    public function testUpdateWithAllNoteData()
    {
        $user = factory(User::class)
            ->create();
        factory(Note::class, 10)
            ->create([
                'user_id' => $user->id,
            ]);
        $id = (new Note())
            ->select('id')
            ->inRandomOrder()
            ->limit(1)
            ->pluck('id')
            ->first();

        $tags = factory(Tag::class, 10)
            ->create([
                'user_id' => $user->id,
            ])
            ->pluck('id')
            ->random(2)
            ->toArray();

        $title = 'new title ' . Str::random();
        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->put(
                route('notesUpdate', ['noteId' => $id]),
                [
                    'title' => $title,
                    'body' => $body,
                    'tags' => $tags,
                ]
            )
            ->assertRedirect(route('notesEdit', ['noteId' => $id]))
        ;
        $this->assertDatabaseHas('notes', [
            'id' => $id,
            'title' => $title,
            'body' => $body,
        ]);
        foreach ($tags as $tagId) {
            $this->assertDatabaseHas('note_tag', [
                'note_id' => $id,
                'tag_id' => $tagId,
            ]);
        }
    }

    public function testCreate()
    {
        $user = factory(User::class)
            ->create();
        $this
            ->actingAs($user)
            ->get(route('notesCreate'))
            ->assertStatus(200)
        ;
    }

    public function testAddFailsWithNoNoteDataSent()
    {
        $user = factory(User::class)
            ->create();
        $this
            ->actingAs($user)
            ->post(route('notesAdd'))
            ->assertStatus(302)
        ;
    }

    public function testAddWithRequiredData()
    {
        $user = factory(User::class)
            ->create();

        $title = 'new title ' . Str::random();
        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->post(
                route('notesAdd'),
                [
                    'title' => $title,
                    'body' => $body,
                ]
            )
            ->assertRedirect(route('notes'))
        ;
        $this->assertDatabaseHas('notes', [
            'title' => $title,
            'body' => $body,
        ]);
    }

    public function testAddWithAllNoteData()
    {
        $user = factory(User::class)
            ->create();

        $tags = factory(Tag::class, 10)
            ->create([
                'user_id' => $user->id,
            ])
            ->pluck('id')
            ->random(2)
            ->toArray();

        $title = 'new title ' . Str::random();
        $body = 'new body text, new body text, new body text ' . Str::random();
        $this
            ->actingAs($user)
            ->post(
                route('notesCreate'),
                [
                    'title' => $title,
                    'body' => $body,
                    'tags' => $tags,
                ]
            )
            ->assertRedirect(route('notes'))
        ;
        $id = (new Note())
            ->select('id')
            ->orderBy('id', 'DESC')
            ->first()
            ->pluck('id');
        $this->assertDatabaseHas('notes', [
            'title' => $title,
            'body' => $body,
        ]);
        foreach ($tags as $tagId) {
            $this->assertDatabaseHas('note_tag', [
                'note_id' => $id,
                'tag_id' => $tagId,
            ]);
        }
    }

    public function testDestroyFailsWithInvalidNoteId()
    {
        $user = factory(User::class)
            ->create();
        factory(Note::class, 10)
            ->create([
                'user_id' => $user->id,
            ]);

        $this
            ->actingAs($user)
            ->delete(route('notesDestroy', ['noteId' => 876567456]))
            ->assertStatus(404)
        ;
    }

    public function testDestroy()
    {
        $user = factory(User::class)
            ->create();
        factory(Note::class, 10)
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
            ->delete(route('notesDestroy', ['noteId' => $id]))
            ->assertRedirect(route('notes'))
        ;
        $this->assertSoftDeleted('notes', [
            'id' => $id,
        ]);
    }

    public function testTagListing()
    {
        $user = factory(User::class)
            ->create();

        factory(Tag::class, 20)
            ->create([
                'user_id' => $user->id,
            ]);

        $this
            ->actingAs($user)
            ->get(route('notesTags'))
            ->assertStatus(200)
        ;
    }

    public function testTagListingWithNoTags()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('notesTags'))
            ->assertStatus(200)
        ;
    }

    public function testTagListingWithRelatedNotes()
    {
        $user = factory(User::class, 2)
            ->create();
        $tags = factory(Tag::class, 20)
            ->create()
            ->pluck('id');
        factory(Note::class, 10)
            ->create()
            ->each(function (Note $note) use ($tags) {
                $note->tags()->sync($tags->random(mt_rand(1, 3))->toArray());
            });

        $this
            ->actingAs($user->first())
            ->get(route('notesTags'))
            ->assertStatus(200)
        ;
    }

    public function testTagCreate()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->get(route('notesTagsCreate'))
            ->assertStatus(200)
        ;
    }

    public function testTagAddFailsWithNoData()
    {
        $user = factory(User::class)
            ->create();

        $this
            ->actingAs($user)
            ->post(route('notesTagsAdd'))
            ->assertStatus(302)
        ;
    }

    public function testTagAdd()
    {
        $user = factory(User::class)
            ->create();
        $tag = "TagName";
        $finalTagName = Str::lower($tag);
        $data = ['tag' => $tag];

        $this
            ->actingAs($user)
            ->post(route('notesTagsAdd', $data))
            ->assertRedirect(route('notesTags', ['_', 'created' => $finalTagName]))
        ;
        $this->assertDatabaseHas('tags', [
            'tag' => $finalTagName,
        ]);
    }

    public function testTagAddFailWithExistingTag()
    {
        $user = factory(User::class)
            ->create();
        $tag = factory(Tag::class, 3)
            ->create()
            ->random(1)
            ->first()
            ->tag;
        $data = ['tag' => $tag];

        $this
            ->actingAs($user)
            ->post(route('notesTagsAdd', $data))
            ->assertStatus(302)
        ;
    }
}
