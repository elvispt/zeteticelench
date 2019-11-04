<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovementCreate;
use App\Models\Movement;
use App\Repos\Expenses\Accounts;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
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

    public function create()
    {
        $account = (new Accounts())
            ->get(Auth::user())
            ->first()
        ;

        return View::make('expenses/movements-new', [
            'title' => 'expenses.movements_new',
            'account' => $account,
        ]);
    }

    public function add(MovementCreate $request)
    {
        $validated = new Collection($request->validated());

        $movement = new Movement();

        $account = (new Accounts())
            ->get(Auth::user())
            ->first()
        ;
        $movement->account_id = $account->id;
        $movement->amount = $validated->get('amount');
        $movement->description = $validated->get('description');
        $date = $validated->get('date');
        $time = $validated->get('time');
        $amountDate = Carbon::createFromFormat(
            'Y-m-d H:i',
            "$date $time"
        );
        $movement->amount_date = $amountDate;

        $movement->save();

        return redirect(route('movements'));
    }
}
