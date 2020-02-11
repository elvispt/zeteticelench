<?php

namespace App\Http\Requests;

use App\Repos\Expenses\Accounts;
use App\Repos\Tags\TagType;
use App\Rules\ExistsWithUser;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MovementUpdate extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                'int',
                Rule::exists('movements')
                    ->where(static function (Builder $query) {
                        $userAccounts = (new Accounts())
                            ->get(Auth::user())
                            ->pluck('id')
                            ->toArray()
                        ;
                        $query->whereIn('account_id', $userAccounts);
                    }),
            ],
            'date' => [
                'required',
                'date_format:Y-m-d',
            ],
            'time' => [
                'required',
                'date_format:H:i',
            ],
            'amount' => [
                'required',
                'numeric',
            ],
            'description' => [
                'sometimes',
                'string',
                'nullable',
            ],
            'tags' => [
                'sometimes',
                'array',
                'nullable',
            ],
            'tags.*' => [
                'sometimes',
                new ExistsWithUser('tags', ['type' => TagType::EXPENSE]),
            ],
        ];
    }
}
