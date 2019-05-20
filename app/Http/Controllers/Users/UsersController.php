<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdate;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
}
