<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use App\Repos\Expenses\Accounts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AccountsController extends Controller
{
    public function index()
    {
        $accounts = new Accounts();

        return View::make('expenses/accounts', [
            'title' => 'expenses.accounts_list',
            'accounts' => $accounts->get(Auth::user()),
        ]);
    }
}
