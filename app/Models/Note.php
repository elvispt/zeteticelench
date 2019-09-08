<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;
use League\CommonMark\CommonMarkConverter;

/**
 * App\Models\Note
 *
 * @property int $id
 * @property int $user_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Note onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Note withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Note withoutTrashed()
 * @mixin \Eloquent
 */
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
        $scoutMetadata = $this->scoutMetadata();
        $body = data_get($scoutMetadata, '_highlightResult.body.value');
        if (!$body) {
            $body = $this->body;
        }

        $commonMarkConverter = new CommonMarkConverter();
        $output = $commonMarkConverter->convertToHtml($body);

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
