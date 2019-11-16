<?php

namespace App\Http\Requests;

class MovementListing extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fromDate' => [
                'sometimes',
                'nullable',
                'date_format:Y-m-d',
            ],
            'toDate' => [
                'sometimes',
                'nullable',
                'date_format:Y-m-d',
            ],
            'tags' => [
                'sometimes',
                'nullable',
                'array'
            ],
        ];
    }
}
