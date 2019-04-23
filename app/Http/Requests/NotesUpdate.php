<?php

namespace App\Http\Requests;

class NotesUpdate extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'min:1',
                'max:50',
            ],
            'body' => [
                'required',
                'string',
                'max:10000',
            ],
        ];
    }
}
