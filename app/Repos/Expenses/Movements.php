<?php

namespace App\Repos\Expenses;

use App\Models\Account;
use App\Models\Movement;
use App\Models\Tag;
use App\Models\User;
use App\Repos\Tags\TagType;
use Illuminate\Database\Eloquent\Builder;
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
                function (Builder $query) use ($tags) {
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

    protected function parseDates(Collection $filters): array {
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
            if ( ! array_key_exists($amountDate, $movInfo->movements)) {
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
     * Add a new movement
     *
     * @param Collection $validated
     * @param int        $accountId
     *
     * @return bool Returns true on success, false otherwise
     */
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
        $movement = $this->setMovementAttributes($movement, $validated);

        $isStored = $this->storeMovement($movement);
        $tags = $validated->get('tags', []);
        if ($isStored) {
            $movement->tags()->sync($tags);
        }

        return $isStored;
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

    /**
     * Get tags for expenses attached to the given user
     *
     * @param User $user The user's model
     *
     * @return Collection<Tag>
     */
    public function getUserTags(User $user): Collection
    {
        return (new Tag())
            ->where('type', TagType::EXPENSE)
            ->where('user_id', $user->id)
            ->get();
    }

    /**
     * @param User $user
     * @param      $id
     *
     * @return Movement|null
     */
    public function getUserMovement(User $user, $id)
    {
        $accountIds = (new Accounts())
            ->get($user)
            ->pluck('id')
            ->toArray();

        return (new Movement())
            ->where('id', $id)
            ->whereIn('account_id', $accountIds)
            ->first();
    }

    public function update(Collection $validated): bool
    {
        $movement = (new Movement())
            ->where('id', $validated->get('id'))
            ->first()
        ;
        if (!$movement) {
            return false;
        }

        $movement->amount = $validated->get('amount');
        $movement = $this->setMovementAttributes($movement, $validated);

        $isStored = $this->storeMovement($movement);
        $tags = $validated->get('tags', []);
        if ($isStored) {
            $movement->tags()->sync($tags);
        }

        return $isStored;
    }

    /**
     * Set a movement model attributes that are common between creating a new
     * movement and updating an existing movement
     *
     * @param Movement   $movement
     * @param Collection $validated
     *
     * @return Movement
     */
    protected function setMovementAttributes(Movement $movement, Collection $validated)
    {
        $movement->description = $validated->get('description');
        $date = $validated->get('date');
        $time = $validated->get('time');
        $amountDate = Carbon::createFromFormat(
            'Y-m-d H:i',
            "$date $time"
        );
        $movement->amount_date = $amountDate;

        return $movement;
    }

    /**
     * Makes DB request to store movement
     *
     * @param Movement $movement The movement model with the data to save
     *
     * @return bool Returns true on success, false otherwise
     */
    protected function storeMovement(Movement $movement): bool
    {
        $isStored = false;
        try {
            $isStored = $movement->save();
        } catch (QueryException $exception) {
            $isStored = false;
            Log::error(
                "Could not store movement",
                ['eMessage' => $exception->getMessage()]
            );
        } catch (\Exception $exception) {
            Log::error(
                "Could not store movement",
                ['eMessage' => $exception->getMessage()]
            );
        }
        return $isStored;
    }
}
