<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesUpdate;
use App\Http\Requests\TagCreate;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class NotesController extends Controller
{
    public function index($noteId = null)
    {
        $userId = Auth::id();
        $notes = (new Note())
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'DESC')
            ->get();

        $currentNote = $notes
            ->where('id', $noteId)
            ->where('user_id', $userId)
            ->first()
        ;
        $notes = $notes->map(function (Note $note) {
            $note->tags;
            $n = (Object) $note->toArray();
            $n->tags = (new Collection($n->tags))
                ->pluck('tag')
                ->toArray();
            return (Object) $n;
        });
        $tags = Tag::all();
        return View::make('notes/notes', [
            'notes' => $notes,
            'currentNote' => $currentNote,
            'tags' => $tags,
        ]);
    }

    public function update(NotesUpdate $request, $noteId)
    {
        $validated = new Collection($request->validated());
        $note = (new Note)
            ->where('id', $noteId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$note) {
            return redirect(route('notes'));
        }

        $note->title = $validated->get('title', '');
        $note->body = $validated->get('body', '');

        $note->save();

        $tags = $validated->get('tags', []);
        $result = $note->tags()->sync($tags);
        if (!empty($result['attached'])
            || !empty($result['detached'])
            || !empty($result['updated'])
        ) {
            $note->touch();
        }

        return redirect(route('notes', ['noteId' => $noteId]));
    }

    public function create()
    {
        $userId = Auth::id();
        $notes = (new Note())
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'DESC')
            ->get();
        $notes = $notes->map(function (Note $note) {
            $note->tags;
            $n = (Object) $note->toArray();
            $n->tags = (new Collection($n->tags))
                ->pluck('tag')
                ->toArray();
            return (Object) $n;
        });
        $tags = Tag::all();
        return View::make('notes/notes-new', [
            'notes' => $notes,
            'tags' => $tags,
        ]);
    }

    public function add(NotesUpdate $request)
    {
        $validated = new Collection($request->validated());

        $note = new Note();

        $note->user_id = Auth::id();
        $note->title = $validated->get('title', '');
        $note->body = $validated->get('body', '');

        $note->save();

        $tags = $validated->get('tags', []);
        $note->tags()->sync($tags);

        return redirect(route('notes', ['noteId' => $note->id]));
    }

    public function destroy($noteId)
    {
        $note = (new Note)
            ->where('id', $noteId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$note) {
            return redirect(route('notes'));
        }

        $note->delete();

        return redirect(route('notes'));
    }

    public function tags($tagId = null)
    {
        $tags = Tag::withCount('notes')
            ->orderBy('notes_count', 'desc')
            ->get();
        $tagId = (int) $tagId;

        $currentTag = $tags
            ->where('id', $tagId)
            ->first();

        return View::make('notes/tags', [
            'tags' => $tags,
            'currentTag' => $currentTag,
        ]);
    }

    public function tagCreate()
    {
        return View::make('notes/tag-create');
    }

    public function tagAdd(TagCreate $request)
    {
        $validated = new Collection($request->validated());
        $tagName = $validated->get('tag');

        $tag = new Tag();
        $tag->tag = $tagName;
        $tag->save();

        return back();
    }
}
