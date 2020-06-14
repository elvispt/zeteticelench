<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreate;
use App\Http\Requests\UserDestroy;
use App\Http\Requests\UserUpdate;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\Users\UserResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Shows the list of users
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all()->map(static function (User $user) {
            $userResponse = new UserResponse();
            $userResponse->id = $user->id;
            $userResponse->name = $user->name;
            $userResponse->email = $user->email;
            $userResponse->createdAt = $user->created_at
                ->format('Y-m-d H:i:s');
            $userResponse->updatedAt = $user->updated_at
                ->format('Y-m-d H:i:s');

            return $userResponse;
        });

        return ApiResponse::response((object) [
            'users' => $users,
            'currentUserId' => Auth::id(),
        ]);
    }

    /**
     * Updates the user info according to provided data
     *
     * @param UserUpdate $request Validates the provided data
     *
     * @return JsonResponse
     */
    public function update(UserUpdate $request): JsonResponse
    {
        $validated = new Collection($request->validated());
        $user = (new User())
            ->where('id', $validated->get('id'))
            ->first();
        $user->name = $validated->get('name');
        $success = $user->save();

        return ApiResponse::response([
            "id" => $user->id,
            "success" => $success,
        ]);
    }

    /**
     * Creates a new user according to provided data
     *
     * @param UserCreate $request Validates provided user data
     *
     * @return JsonResponse
     */
    public function add(UserCreate $request): JsonResponse
    {
        $validated = new Collection($request->validated());
        $user = new User();
        $user->name = $validated->get('name');
        $user->email = $validated->get('email');
        $user->password = Hash::make($validated->get('password'));
        $success = $user->save();

        return ApiResponse::response([
            "id" => $user->id,
            "success" => $success,
        ]);
    }

    /**
     * Deletes a single user along with it's associated notes.
     *
     * @param UserDestroy $request Validates that the user request exists.
     *
     * @return JsonResponse
     */
    public function destroy(UserDestroy $request): JsonResponse
    {
        $validated = new Collection($request->validated());

        $user = (new User())
            ->where('id', $validated->get('id'))
            ->first();
        $user->tags()->delete();
        foreach ($user->notes()->withTrashed()->get() as $note) {
            $note->forceDelete();
        }
        $success = $user->delete();

        return ApiResponse::response([
            "id" => $user->id,
            "success" => $success,
        ]);
    }
}
