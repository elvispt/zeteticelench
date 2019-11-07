<?php

namespace App\Repos\Expenses;

use App\Models\Account;
use App\Models\Movement;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use stdClass;

class Movements
{
    public const CREDIT = 'CREDIT';
    public const DEBIT = 'DEBIT';

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

    public function add(Collection $validated, int $accountId): bool
    {
        $movement = new Movement();
        $movement->account_id = $accountId;
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

        $result = false;
        try {
            $result = $movement->save();
        } catch (QueryException $exception) {
            $result = false;
            Log::error(
                "Could not store movement",
                [
                    'eMessage' => $exception->getMessage(),
                    'validated' => print_r($validated, true),
                    'accountId' => $accountId,
                ]
            );
        } catch (\Exception $exception) {
            Log::error(
                "Could not store movement",
                [
                    'eMessage' => $exception->getMessage(),
                    'validated' => print_r($validated, true),
                    'accountId' => $accountId,
                ]
            );
        }
        return $result;
    }
}
