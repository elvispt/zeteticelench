<?php

namespace App\Repos\Expenses;

use App\Models\Account;
use App\Models\Movement;
use stdClass;

class Movements
{
    /**
     * Returns an object with the list of expenses
     *
     * @param Account $account The account from which to get the expenses from
     *
     * @return mixed
     */
    public function movementsGroupedByDate(Account $account)
    {
        $movementsCollection = $account
            ->movements()
            ->orderBy('amount_date', 'DESC')
            ->get()
        ;
        $m = new stdClass();
        $m->movements = [];
        $m->total = 0;

        return $movementsCollection->reduce(function (stdClass $m, Movement $movement) {
            $amountDate = $movement->amount_date->format('Y-m-d');
            if (!array_key_exists($amountDate, $m->movements)) {
                $m->movements[$amountDate] = new stdClass();
                $m->movements[$amountDate]->movements = [];
                $m->movements[$amountDate]->total = 0;
            }
            $m->movements[$amountDate]->movements[] = $movement;
            $m->movements[$amountDate]->total += $movement->amount;
            $m->total += $movement->amount;
            return $m;
        }, $m);
    }
}
