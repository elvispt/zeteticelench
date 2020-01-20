<?php

namespace App\Repos\Expenses;

use App\Models\Movement;
use App\Models\Tag;
use App\Models\User;
use App\Repos\Tags\TagType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Movements
{
    public const CREDIT = 'CREDIT';
    public const DEBIT = 'DEBIT';

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
            "${date} ${time}"
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
        } catch (\Exception $exception) {
            Log::error(
                'Could not store movement',
                ['eMessage' => $exception->getMessage()]
            );
        }
        return $isStored;
    }
}
