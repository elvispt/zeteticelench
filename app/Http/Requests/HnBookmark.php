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
            'story_id' => [
                'required',
                'exists:hacker_news_items,id',
            ],
        ];
    }
}
