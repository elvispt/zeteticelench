<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExistsWithUser implements Rule
{
    protected $userId;

    protected $table;

    /**
     * Create a new rule instance.
     *
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->userId = Auth::id();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table($this->table)
            ->where('id', $value)
            ->where('user_id', $this->userId)
            ->exists();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid tag identifier';
    }
}
