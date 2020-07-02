<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseCreate;
use App\Http\Responses\ApiResponse;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $expenses = (new Expense())
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'DESC')
            ->get()
        ;

        return ApiResponse::response($expenses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExpenseCreate $request
     *
     * @return JsonResponse
     */
    public function store(ExpenseCreate $request): JsonResponse
    {
        $userId = $request->user()->id;
        $validated = new Collection($request->validated());
        $expense = new Expense();
        $expense->user_id = $userId;
        $expense->description = $validated->get('description');
        $expense->amount = $validated->get('amount');

        $success = $expense->save();

        return ApiResponse::response((object) [
            'success' => $success,
            'expense' => $expense,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Expense  $expense
     * @return Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param Expense $expense
     *
     * @return Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Expense $expense
     * @return Response
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
