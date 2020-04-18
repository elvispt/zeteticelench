<?php

namespace App\Http\Responses\Notes;

use App\Http\Responses\ApiIdNameResponse;

class SimpleNoteResponse
{
    public int $id;

    public string $title;

    public string $updated_at;

    /**
     * @var ApiIdNameResponse[]
     */
    public array $tags = [];

    public string $body;
}
