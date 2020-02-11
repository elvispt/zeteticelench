<?php

namespace App\Repos\Expenses;

use App\Models\Account;
use App\Models\Movement;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use stdClass;

class MovementsGroupedByDay
{
    /**
     * Returns an object with the list of expenses
     *
     * @param Account    $account The account from which to get the expenses from
     * @param Collection $filters
     *
     * @return mixed
     */
    public function movementsGroupedByDay(
        Account $account,
        Collection $filters
    ) {
        $tags = $filters->get('tags');
        if ($tags) {
            $movements = Movement::whereHas(
                'tags',
                static function (Builder $query) use ($tags) {
                    $query->whereIn('movement_tag.tag_id', $tags);
                });
        } else {
            $movements = Movement::with('tags');
        }
        [$fromDate, $toDate] = $this->parseDates($filters);
        $movements
            ->where('account_id', $account->id)
            ->whereBetween('amount_date', [$fromDate, $toDate])
            ->orderBy('amount_date', 'DESC')
        ;

        $movementsCollection = $movements->get();

        $movInfo = new stdClass();
        $movInfo->movements = [];
        $movInfo->total = 0;
        $movInfo->totalAmountPerTag = [];

        $movInfo = $this->totalAmountPerTag($movementsCollection, $movInfo);

        return $this->parseMovementsByDay($movementsCollection, $movInfo);
    }

    protected function parseDates(Collection $filters): array
    {
        $fromDate = $filters->get('fromDate');
        $toDate = $filters->get('toDate');
        if ($fromDate) {
            $from = Carbon::createFromFormat('Y-m-d', $fromDate)
                ->startOfDay();
        } else {
            $from = Carbon::now()
                ->startOfDay()
                ->startOfMonth();
        }
        if ($toDate) {
            $to = Carbon::createFromFormat('Y-m-d', $toDate)
                ->endOfDay();
        } else {
            $to = Carbon::now()
                ->endOfDay()
                ->endOfMonth();
        }

        return [$from, $to];
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
        return $movementsCollection->reduce(static function (
            stdClass $movInfo,
            Movement $movement
        ) {
            $amountDate = $movement->amount_date->format('Y-m-d');
            if (! array_key_exists($amountDate, $movInfo->movements)) {
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

    /**
     * Calculates the given movements total amount grouped by tags
     *
     * @param Collection $movementsCollection
     * @param stdClass   $movInfo
     *
     * @return mixed|stdClass
     */
    protected function totalAmountPerTag(
        Collection $movementsCollection,
        stdClass $movInfo
    ) {
        $movInfo = $movementsCollection->reduce(static function (
            stdClass $movInfo,
            Movement $movement
        ) {
            return $movement->tags->reduce(static function (
                stdClass $movInfo,
                Tag $tag
            ) use ($movement) {
                $id = $tag->id;
                if (!array_key_exists($id, $movInfo->totalAmountPerTag)) {
                    $movInfo->totalAmountPerTag[$id] = (object) [
                        'id' => $id,
                        'name' => $tag->tag,
                        'amount' => 0,
                    ];
                }
                $movInfo->totalAmountPerTag[$id]->amount += $movement->amount;

                return $movInfo;
            }, $movInfo);
        }, $movInfo);

        $movInfo->totalAmountPerTag
            = $this->sortTagAmounts($movInfo->totalAmountPerTag);

        return $movInfo;
    }

    /**
     * Sort the given tags and amount by the amount
     *
     * @param $totalAmountPerTag
     *
     * @return array
     */
    protected function sortTagAmounts($totalAmountPerTag)
    {
        return (new Collection($totalAmountPerTag))
            ->sortBy('amount')
            ->values()
            ->toArray();
    }
}
