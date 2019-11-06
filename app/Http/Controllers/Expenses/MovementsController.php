<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovementCreate;
use App\Models\Movement;
use App\Repos\Expenses\Accounts;
use App\Repos\Expenses\Movements;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class MovementsController extends Controller
{
    public const CREDIT = 'CREDIT';
    public const DEBIT = 'DEBIT';

    public function index()
    {
        $account = (new Accounts())
            ->get(Auth::user())
            ->first()
        ;
        $movements = new Movements();
        $movementsGroupedByDate = $movements->movementsGroupedByDate($account);

        return View::make('expenses/movements', [
            'title' => 'expenses.movements_list',
            'account' => $account,
            'movementsGroupedByDate' => $movementsGroupedByDate,
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
        $creditDebit = $validated->get('credit-debit');
        $amount = $validated->get('amount');
        if ($creditDebit == static::DEBIT) {
            $amount = -1 * ($amount);
        }
        $movement->amount = $amount;
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
