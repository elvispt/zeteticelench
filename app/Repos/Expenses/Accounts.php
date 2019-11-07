<?php

namespace App\Repos\Expenses;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class Accounts
{
    public function get(User $user): Collection
    {
        return (new Account())
            ->where('user_id', $user->id)
            ->get();
    }
}
