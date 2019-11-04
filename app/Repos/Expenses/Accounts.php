<?php

namespace App\Repos\Expenses;

use App\Models\Account;
use App\Models\User;

class Accounts
{
    public function get(User $user)
    {
        $accounts = (new Account())
            ->where('user_id', $user->id)
            ->get();
        return $accounts;
    }
}
