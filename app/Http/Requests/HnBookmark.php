<?php

namespace App\Http\Requests;

class HnBookmark extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'postId' => [
                'required',
                'int',
            ],
        ];
    }
}
