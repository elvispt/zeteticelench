<?php

namespace App\Http\Requests;

class TagCreate extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tag' => [
                'required',
                'string',
                'min:1',
                'max:50',
                'unique:tags,tag',
            ],
        ];
    }
}
