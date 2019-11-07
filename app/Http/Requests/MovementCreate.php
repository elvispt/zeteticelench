<?php

namespace App\Http\Requests;

use App\Repos\Expenses\Movements;
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
            ]
        ];
    }
}
