<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotesUpdate;
use App\Http\Requests\TagCreate;
use App\Http\Responses\ApiIdNameResponse;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\Notes\SimpleNoteResponse;
use App\Models\Note;
use App\Models\Tag;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            $simpleNoteResponse->tags = $note
                ->tags()
                ->get()
                ->map(static function (Tag $tag) {
                    $idNameResponse = new ApiIdNameResponse();
                    $idNameResponse->id = $tag->id;
                    $idNameResponse->name = $tag->tag;
                    return $idNameResponse;
                })
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
        $simpleNoteResponse->tags = $note
            ->tags()
            ->get()
            ->map(static function (Tag $tag) {
               $idNameResponse = new ApiIdNameResponse();
               $idNameResponse->id = $tag->id;
               $idNameResponse->name = $tag->tag;
               return $idNameResponse;
            })
            ->toArray();

        $simpleNoteResponse->updated_at = $note->updated_at->format('Y-m-d H:i:s');
        if ($request->get('html')) {
            $simpleNoteResponse->body = $note->bodyToHtml(NOTE::WITH_SYNTAX_HIGHLIGHTING);
        } else {
            $simpleNoteResponse->body = $note->body;
        }


        return ApiResponse::response($simpleNoteResponse);
    }

    public function tags()
    {
        $userId = Auth::id();
        $tags = (new Tag())
            ->where('user_id', $userId)
            ->get()
            ->map(static function ($tag) {
                $tagResponse = new ApiIdNameResponse();
                $tagResponse->id = $tag->id;
                $tagResponse->name = $tag->tag;

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

        return ApiResponse::response([
            "id" => $note->id,
            "success" => true
        ]);
    }

    /**
     * Updates the notes with the provided data on the request.
     *
     * @param NotesUpdate $request Validates the data sent
     * @param int|null    $noteId  The note identifier
     *
     * @return JsonResponse
     */
    public function update(NotesUpdate $request, $noteId): JsonResponse
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

        return ApiResponse::response([
            "id" => $note->id,
            "success" => true
        ]);
    }

    /**
     * Deletes the note identified by the $noteId
     *
     * @param int $noteId The note identifier.
     *
     * @return JsonResponse
     */
    public function destroy($noteId): JsonResponse
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
            return abort(500);
        }

        return ApiResponse::response([
            'id' => $noteId,
            'success' => true,
        ]);
    }

    /**
     * Creates a tag with the provided information.
     *
     * @param TagCreate $request Validates the tag data provided.
     *
     * @return JsonResponse
     */
    public function tagAdd(TagCreate $request): JsonResponse
    {
        $validated = new Collection($request->validated());
        $tagName = Str::lower($validated->get('tag'));

        $tag = new Tag();
        $tag->user_id = Auth::id();
        $tag->tag = $tagName;
        $tag->save();

        return ApiResponse::response([
            "id" => $tag->id,
            "success" => true
        ]);
    }
}
