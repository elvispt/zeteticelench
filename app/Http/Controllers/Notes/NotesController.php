<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class NotesController extends Controller
{
    /**
     * Shows the list of notes
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return View::make('vuejs/notes/notes');
    }

    /**
     * Deletes the note identified by the $noteId
     *
     * @param int $noteId The note identifier.
     *
     * @return RedirectResponse|Redirector|void
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
        } catch (Exception $exception) {
            Log::error(
                "Could not delete note with id: ${noteId}.",
                ['eMessage' => $exception->getMessage()]
            );
        }

        return redirect(route('notes'));
    }
}
