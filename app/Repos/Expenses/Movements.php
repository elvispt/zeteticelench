<?php

namespace App\Repos\Expenses;

use App\Models\Account;
use App\Models\Movement;
use App\Models\Tag;
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
    public function movementsGroupedByDay(Account $account)
    {
        $movementsCollection = $account
            ->movements()
            ->orderBy('amount_date', 'DESC')
            ->get()
        ;
        $movInfo = new stdClass();
        $movInfo->movements = [];
        $movInfo->total = 0;
        $movInfo->totalAmountPerTag = [];

        $movInfo = $this->totalAmountPerTag($movementsCollection, $movInfo);
        return $this->parseMovementsByDay($movementsCollection, $movInfo);
    }

    /**
     * Grabs the list of movements and groups them by day
     *
     * @param Collection $movementsCollection
     * @param stdClass   $movInfo
     *
     * @return mixed
     */
    protected function parseMovementsByDay(
        Collection $movementsCollection,
        stdClass $movInfo
    ) {
        return $movementsCollection->reduce(static function (stdClass $movInfo, Movement $movement) {
            $amountDate = $movement->amount_date->format('Y-m-d');
            if (!array_key_exists($amountDate, $movInfo->movements)) {
                $movInfo->movements[$amountDate] = new stdClass();
                $movInfo->movements[$amountDate]->movements = [];
                $movInfo->movements[$amountDate]->total = 0;
            }
            $movInfo->movements[$amountDate]->movements[] = $movement;
            $movInfo->movements[$amountDate]->total += $movement->amount;
            $movInfo->total += $movement->amount;
            return $movInfo;
        }, $movInfo);
    }

    public function add(Collection $validated, int $accountId): bool
    {
        $movement = new Movement();
        $movement->account_id = $accountId;
        $creditDebit = $validated->get('credit-debit');
        $amount = $validated->get('amount');
        if ($creditDebit === self::DEBIT) {
            $amount = -1 * $amount;
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
        $tags = $validated->get('tags', []);
        if ($result ) {
            $movement->tags()->sync($tags);
        }
        return $result;
    }

    public function totalAmountPerTag(
        Collection $movementsCollection,
        stdClass $movInfo
    ) {
        $movInfo = $movementsCollection->reduce(static function (stdClass $movInfo, Movement $movement) {
            return $movement->tags->reduce(static function (stdClass$movInfo, Tag $tag) use ($movement) {
                $tagName = $tag->tag;
                if (!array_key_exists($tagName, $movInfo->totalAmountPerTag)) {
                    $movInfo->totalAmountPerTag[$tagName] = 0;
                }
                $movInfo->totalAmountPerTag[$tagName] += $movement->amount;

                return $movInfo;
            }, $movInfo);
        }, $movInfo);

        $movInfo->totalAmountPerTag = $this->sortTagAmounts($movInfo->totalAmountPerTag);

        return $movInfo;
    }

    protected function sortTagAmounts($totalAmountPerTag)
    {
        return (new Collection($totalAmountPerTag))
            ->sort()
            ->toArray();
    }

}
