<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovementCreate;
use App\Repos\Expenses\Accounts;
use App\Repos\Expenses\Movements;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class MovementsController extends Controller
{
    /**
     * Shows page with movements for the first account
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $account = (new Accounts())
            ->get(Auth::user())
            ->first()
        ;
        if ($account) {
            $movements = new Movements();
            $movementsGroupedByDate = $movements->movementsGroupedByDay($account);
            return View::make('expenses/movements', [
                'title' => 'expenses.movements_list',
                'account' => $account,
                'movementsGroupedByDate' => $movementsGroupedByDate,
            ]);
        } else {
            return View::make('expenses/movements', [
                'title' => 'expenses.movements_list',
                'account' => $account,
                'movementsGroupedByDate' => null,
            ]);
        }
    }

    /**
     * Shows page with form to create a new movement
     *
     * @return \Illuminate\Contracts\View\View
     */
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

    /**
     * Add new movement
     *
     * @param MovementCreate $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add(MovementCreate $request)
    {
        $validated = new Collection($request->validated());
        $account = (new Accounts())
            ->get(Auth::user())
            ->first()
        ;
        $movements = new Movements();
        $success = $movements->add($validated, $account->id);
        if (!$success) {
            return back()
                ->withErrors([trans('expenses.failed_to_add_movement')]);
        }
        return redirect(route('movements'));
    }
}
