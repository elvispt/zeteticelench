<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
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
}
