<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesUpdate;
use App\Http\Requests\TagCreate;
use App\Models\Note;
use App\Models\Tag;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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

    /**
     * Shows the list of tags. If a tagId is provided it will also show the
     * notes that have that tag attached to id.
     *
     * @param Request  $request
     * @param int|null $tagId Optional. The tag identifier.
     *
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
     *
     * @return RedirectResponse|Redirector
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
