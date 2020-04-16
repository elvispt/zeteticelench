<?php

namespace App\Http\Controllers\Api\Notes;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\Notes\SimpleNoteResponse;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
}
