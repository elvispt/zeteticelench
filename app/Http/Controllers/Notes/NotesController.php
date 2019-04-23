<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
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
}
