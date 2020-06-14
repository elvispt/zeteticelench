<?php

namespace App\Http\Requests;

class UserCreate extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'min:12',
                'max:100',
            ],
        ];
    }
}
