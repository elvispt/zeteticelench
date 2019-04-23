<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesUpdate;
use App\Models\Note;
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
}
