<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use App\Repos\Expenses\Accounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class MovementsController extends Controller
{
    public function index()
    {
        $account = (new Accounts())
            ->get(Auth::user())
            ->first()
        ;
        $movements = $account
            ->movements()
            ->orderBy('created_at', 'DESC')
            ->get()
        ;
        return View::make('expenses/movements', [
            'title' => 'expenses.movements_list',
            'account' => $account,
            'movements' => $movements,
        ]);
    }
}
