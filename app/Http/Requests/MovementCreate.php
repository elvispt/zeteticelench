<?php

namespace App\Http\Requests;

use App\Repos\Expenses\Movements;
use App\Repos\Tags\TagType;
use App\Rules\ExistsWithUser;
use Illuminate\Validation\Rule;

class MovementCreate extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
            'credit-debit' => [
                'required',
                Rule::in([
                    Movements::CREDIT,
                    Movements::DEBIT
                ]),
            ],
            'tags' =>  [
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
