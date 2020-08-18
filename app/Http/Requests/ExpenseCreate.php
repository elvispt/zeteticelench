<?php

namespace App\Http\Requests;

class ExpenseCreate extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => [
                'required',
                'string',
                'min:1',
                'max:255',
            ],
            'amount' => [
                'required',
                'numeric',
                'between:0,999999',
            ],
            'transactionDate' => [
                'required',
                'date_format:Y-m-d H:i:s',
            ],
        ];
    }
}
