<?php

namespace App\Http\Requests;

use App\Rules\ExistsWithUser;

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
            'body' => [
                'required',
                'string',
                'max:100000',
            ],
            'tags' => [
                'sometimes',
                'array',
            ],
            'tags.*' => [
                'sometimes',
                new ExistsWithUser('tags'),
            ],
        ];
    }
}
