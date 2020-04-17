<?php

namespace App\Http\Responses\Notes;

class SimpleNoteResponse
{
    public int $id;

    public string $title;

    public string $updated_at;

    public array $tags = [];

    public string $body;
}
