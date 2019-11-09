<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExistsWithUser implements Rule
{
    protected $userId;

    protected $table;

    protected $columnsValues;

    /**
     * Create a new rule instance.
     *
     * @param string $table
     * @param array  $columnsValues Key should be column name
     */
    public function __construct($table, $columnsValues = [])
    {
        $this->table = $table;
        $this->userId = Auth::id();
        $this->columnsValues = $columnsValues;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $check = DB::table($this->table)
            ->where('id', $value)
            ->where('user_id', $this->userId);
        if (is_array($this->columnsValues) && count($this->columnsValues)) {
            foreach ($this->columnsValues as $column => $value) {
                $check = $check->where($column, $value);
            }
        }

        return $check->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.invalid_tag');
    }
}
