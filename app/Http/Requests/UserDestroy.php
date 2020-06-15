<?php

namespace App\Http\Requests;

class UserDestroy extends BaseFormRequest
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
                'exists:users,id',
            ],
        ];
    }
}
