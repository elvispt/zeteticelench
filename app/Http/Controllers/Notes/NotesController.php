<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesUpdate;
use App\Http\Requests\TagCreate;
use App\Models\Note;
use App\Models\Tag;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class NotesController extends Controller
{
    /**
     * Shows the list of notes
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = $request->get('query');
        $userId = Auth::id();
        if ($query) {
            $notes = Note::search($query)
                ->where('user_id', $userId)
                ->get();
        } else {
            $notes = (new Note())
                ->where('user_id', $userId)
                ->orderBy('updated_at', 'DESC')
                ->get();
        }
        $notes = $notes->map(function (Note $note) {
            $note->tags;
            $parsed = (object) $note->toArray();
            $parsed->tags = (new Collection($parsed->tags))
                ->pluck('tag')
                ->toArray();
            $parsed->title = $note->extractTitle();
            $parsed->description = $note->extractDescription();

            return (object) $parsed;
        });

        return View::make('notes/notes', [
            'notes' => $notes,
            'query' => $query,
        ]);
    }

    /**
     * Shows a note converted according to CommonMark
     *
     * @param int $id The note identifier
     * @return \Illuminate\Contracts\View\View|void
     */
    public function show($id)
    {
        $userId = Auth::id();
        $note = (new Note())
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
        if (! $note) {
            return abort(404);
        }

        return View::make('notes/note', [
            'note' => $note,
        ]);
    }

    /**
     * Shows the page for editing a note
     *
     * @param int|null $noteId The note identifier
     * @return \Illuminate\Contracts\View\View|void
     */
    public function edit($noteId = null)
    {
        $userId = Auth::id();

        $currentNote = (new Note())
            ->where('id', $noteId)
            ->where('user_id', $userId)
            ->first()
        ;
        if (!$currentNote) {
            return abort(404);
        }
        $tags = (new Tag())
            ->where('user_id', $userId)
            ->get()
        ;
        return View::make('notes/notes-edit', [
            'currentNote' => $currentNote,
            'tags' => $tags,
        ]);
    }

    /**
     * Updates the notes with the provided data on the request.
     *
     * @param NotesUpdate $request Validates the data sent
     * @param int|null    $noteId The note identifier
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function update(NotesUpdate $request, $noteId)
    {
        $validated = new Collection($request->validated());
        $note = (new Note())
            ->where('id', $noteId)
            ->where('user_id', Auth::id())
            ->first();
        if (! $note) {
            return abort(404);
        }

        $note->body = $validated->get('body', '');
        $note->save();

        $tags = $validated->get('tags', []);
        $result = $note->tags()->sync($tags);
        if (count(array_filter($result)) > 0) {
            $note->touch();
        }

        return redirect(route('notesShow', ['noteId' => $noteId]));
    }

    /**
     * Shows the page for creating a new note
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $userId = Auth::id();
        $tags = (new Tag())
            ->where('user_id', $userId)
            ->get()
        ;
        return View::make('notes/notes-new', [
            'tags' => $tags,
        ]);
    }

    /**
     * Adds the new note with the provided information.
     *
     * @param NotesUpdate $request Validates the data sent
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add(NotesUpdate $request)
    {
        $validated = new Collection($request->validated());

        $note = new Note();

        $note->user_id = Auth::id();
        $note->body = $validated->get('body', '');

        $note->save();

        $tags = $validated->get('tags', []);
        $note->tags()->sync($tags);

        return redirect(route('notes'));
    }

    /**
     * Deletes the note identified by the $noteId
     *
     * @param int $noteId The note identifier.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function destroy($noteId)
    {
        $note = (new Note())
            ->where('id', $noteId)
            ->where('user_id', Auth::id())
            ->first();

        if (! $note) {
            return abort(404);
        }

        try {
            $note->delete();
        } catch (QueryException $exception) {
            Log::error("Could not delete note with id: $noteId.");
        } catch (Exception $exception) {
            Log::error("Could not delete note with id: $noteId.");
        }

        return redirect(route('notes'));
    }

    /**
     * Shows the list of tags. If a tagId is provided it will also show the
     * notes that have that tag attached to id.
     *
     * @param Request  $request
     * @param int|null $tagId Optional. The tag identifier.
     * @return \Illuminate\Contracts\View\View
     */
    public function tags(Request $request, $tagId = null)
    {
        $userId = Auth::id();
        $createdTag = $request->get('created');
        $tags = Tag::withCount('notes')
            ->where('user_id', $userId)
            ->orderBy('notes_count', 'desc')
            ->orderBy('id', 'DESC')
            ->get();
        $tagId = (int) $tagId;

        $currentTag = $tags
            ->where('id', $tagId)
            ->where('user_id', $userId)
            ->first();

        return View::make('notes/tags', [
            'tags' => $tags,
            'currentTag' => $currentTag,
            'createdTag' => $createdTag,
        ]);
    }

    /**
     * Shows the page for creating a new tag
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function tagCreate()
    {
        return View::make('notes/tag-create');
    }

    /**
     * Creates a tag with the provided information.
     *
     * @param TagCreate $request Validates the tag data provided.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function tagAdd(TagCreate $request)
    {
        $validated = new Collection($request->validated());
        $tagName = Str::lower($validated->get('tag'));

        $tag = new Tag();
        $tag->user_id = Auth::id();
        $tag->tag = $tagName;
        $tag->save();

        return redirect(route('notesTags', ['_', 'created' => $tagName]));
    }
}
