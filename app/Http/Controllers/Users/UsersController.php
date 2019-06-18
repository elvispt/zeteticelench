<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreate;
use App\Http\Requests\UserDestroy;
use App\Http\Requests\UserUpdate;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class UsersController extends Controller
{
    /**
     * Shows the list of users
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::all();
        return View::make('users.users', [
            'users' => $users,
            'currentUserId' => Auth::id(),
        ]);
    }

    /**
     * Shows the page for editing a single user
     *
     * @param int $id The user identifier
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = (new User())
            ->where('id', $id)
            ->first();
        return View::make('users.user', [
            'user' => $user,
            'currentUserId' => Auth::id(),
        ]);
    }

    /**
     * Updates the user info according to provided data
     *
     * @param UserUpdate $request Validates the provided data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdate $request)
    {
        $validated = new Collection($request->validated());
        $user = (new User())
            ->where('id', $validated->get('user-id'))
            ->first();
        $user->name = $validated->get('name');
        $user->save();

        return back();
    }

    /**
     * Shows the page for creating a new user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('users.user-create');
    }

    /**
     * Creates a new user according to provided data
     *
     * @param UserCreate $request Validates provided user data
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add(UserCreate $request)
    {
        $validated = new Collection($request->validated());
        $user = new User();
        $user->name = $validated->get('name');
        $user->email = $validated->get('email');
        $user->password = Hash::make($validated->get('password'));
        $user->save();

        return redirect(route('users-edit', ['id' => $user->id]));
    }

    /**
     * Deletes a single user along with it's associated notes.
     *
     * @param UserDestroy $request Validates that the user request exists.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(UserDestroy $request)
    {
        $validated = new Collection($request->validated());

        $user = (new User())
            ->where('id', $validated->get('user-id'))
            ->first();
        $user->tags()->delete();
        foreach ($user->notes()->withTrashed()->get() as $note) {
            $note->forceDelete();
        }
        $user->delete();

        return redirect(route('users-list'));
    }
}
