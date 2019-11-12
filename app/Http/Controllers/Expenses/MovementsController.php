<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovementCreate;
use App\Http\Requests\MovementUpdate;
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
        $movementsGroupedByDate = null;
        if ($account) {
            $movements = new Movements();
            $movementsGroupedByDate = $movements->movementsGroupedByDay($account);
        }
        return View::make('expenses/movements', [
            'title' => 'expenses.movements_list',
            'account' => $account,
            'movementsGroupedByDate' => $movementsGroupedByDate,
        ]);
    }

    /**
     * Shows page with form to create a new movement
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = Auth::user();
        $account = (new Accounts())
            ->get($user)
            ->first()
        ;
        $movements = new Movements();
        $tags = $movements->getUserTags($user);

        return View::make('expenses/movements-new', [
            'title' => 'expenses.movements_new',
            'account' => $account,
            'tags' => $tags,
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

    public function edit($id = null)
    {
        $user = Auth::user();
        $movements = new Movements();
        $movement = $movements->getUserMovement($user, $id);
        if (!$movement) {
            return abort(404);
        }
        $tags = $movements->getUserTags($user);
        $movementTags = $movement->tags->pluck('id')->toArray();

        return View::make('expenses/movements-edit', [
            'title' => 'expenses.movements_edit',
            'movement' => $movement,
            'movementTags' => $movementTags,
            'tags' => $tags,
        ]);
    }

    public function update(MovementUpdate $request)
    {
        $validated = new Collection($request->validated());
        $movements = new Movements();
        $success = $movements->update($validated);
        if (!$success) {
            return back()
                ->withErrors([trans('expenses.failed_to_update_movement')]);
        }
        return redirect(route('movements'));
    }
}
