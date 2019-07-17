<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;
use League\CommonMark\CommonMarkConverter;

class Note extends Model
{
    use SoftDeletes;

    use Searchable;

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bodyToHtml()
    {
        $commonMarkConverter = new CommonMarkConverter();
        $output = $commonMarkConverter->convertToHtml($this->body);

        return $output;
    }

    public function extractTitle(): string
    {
        $title = "";
        $output = $this->bodyToHtml();
        $exploded = explode("\n", $output);
        if (is_array($exploded) && count($exploded) > 0) {
            $titleTagged = $exploded[0];
            $title = trim(strip_tags($titleTagged));
        }

        return $title;
    }

    public function extractDescription()
    {
        $description = "";
        $output = $this->bodyToHtml();
        $exploded = explode("\n", $output);
        if (is_array($exploded) && count($exploded) > 0) {
            $descriptionTagged = Arr::get($exploded, 1);
            $description = trim(strip_tags($descriptionTagged));
        }

        return $description;
    }
}
