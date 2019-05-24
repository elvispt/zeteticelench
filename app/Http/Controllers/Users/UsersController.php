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
    public function index()
    {
        $users = User::all();
        return View::make('users.users', [
            'users' => $users,
            'currentUserId' => Auth::id(),
        ]);
    }

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

    public function create()
    {
        return View::make('users.user-create');
    }

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
