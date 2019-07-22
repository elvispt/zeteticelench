<?php

namespace App\Http\Requests;

class HnCollapseComment extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'commentId' => [
                'required',
                'exists:hacker_news_items,id',
            ],
        ];
    }
}
