<?php

namespace App\Http\Controllers\Api\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesUpdate;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\Notes\SimpleNoteResponse;
use App\Http\Responses\Notes\TagResponse;
use App\Models\Note;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    /**
     * Shows the list of notes
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
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
        $notes = $notes->map(static function (Note $note) {
            $simpleNoteResponse = new SimpleNoteResponse();
            $simpleNoteResponse->id = $note->id;
            $simpleNoteResponse->title = $note->extractTitle();
            $simpleNoteResponse->tags = $note->tags()
                                             ->pluck('tag')
                                             ->toArray();
            $simpleNoteResponse->updated_at = $note->updated_at->format('Y-m-d H:i:s');

            return $simpleNoteResponse;
        });

        return ApiResponse::response($notes);
    }

    /**
     * Shows a note converted according to CommonMark
     *
     * @param Request $request
     * @param int     $id The note identifier
     *
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse
    {
        $userId = Auth::id();
        $note = (new Note())
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (! $note) {
            return abort(404);
        }

        $simpleNoteResponse = new SimpleNoteResponse();
        $simpleNoteResponse->id = $note->id;
        $simpleNoteResponse->tags = $note->tags()
                                         ->pluck('tag')
                                         ->toArray();
        $simpleNoteResponse->updated_at = $note->updated_at->format('Y-m-d H:i:s');
        $simpleNoteResponse->body = $note->bodyToHtml();

        return ApiResponse::response($simpleNoteResponse);
    }

    public function tags()
    {
        $userId = Auth::id();
        $tags = (new Tag())
            ->where('user_id', $userId)
            ->get()
            ->map(static function ($tag) {
                $tagResponse = new TagResponse();
                $tagResponse->id = $tag->id;
                $tagResponse->tag = $tag->tag;

                return $tagResponse;
            })
        ;

        return ApiResponse::response($tags);
    }

    /**
     * Adds the new note with the provided information.
     *
     * @param NotesUpdate $request Validates the data sent
     *
     * @return JsonResponse
     */
    public function add(NotesUpdate $request): JsonResponse
    {
        $validated = new Collection($request->validated());

        $note = new Note();

        $note->user_id = Auth::id();
        $note->body = $validated->get('body', '');

        $note->save();

        $tags = $validated->get('tags', []);
        $note->tags()->sync($tags);

        return ApiResponse::response(["success" => true]);
    }
}
