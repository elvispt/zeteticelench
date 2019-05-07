<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesUpdate;
use App\Http\Requests\TagCreate;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Support\Collection;
use function view;

class NotesController extends Controller
{
    public function index($noteId = null)
    {
        $notes = Note::all();
        $currentNote = $notes
            ->where('id', $noteId)
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
        return view('notes/notes', [
            'notes' => $notes,
            'currentNote' => $currentNote,
        ]);
    }

    public function update(NotesUpdate $request, $noteId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return redirect(route('notes'));
        }

        $note->title = $request->get('title', '');
        $note->body = $request->get('body', '');

        $note->save();

        return redirect(route('notes', ['noteId' => $noteId]));
    }

    public function create()
    {
        $notes = Note::all();

        return view('notes/notes-new', [
            'notes' => $notes,
        ]);
    }

    public function add(NotesUpdate $request)
    {
        $note = new Note();

        $note->title = $request->get('title', '');
        $note->body = $request->get('body', '');

        $note->save();

        return redirect(route('notes', ['noteId' => $note->id]));
    }

    public function destroy($noteId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return redirect(route('notes'));
        }

        $note->delete();

        return redirect(route('notes'));
    }

    public function tags($tagId = null)
    {
        $tags = Tag::all();
        $tagId = (int) $tagId;

        $currentTag = $tags
            ->where('id', $tagId)
            ->first();

        return view('notes/tags', [
            'tags' => $tags,
            'currentTag' => $currentTag,
        ]);
    }

    public function tagCreate()
    {
        return view('notes/tag-create');
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
