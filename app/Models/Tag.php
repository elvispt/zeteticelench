<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property int $user_id
 * @property string $tag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Note[] $notes
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUserId($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    public function notes()
    {
        return $this->belongsToMany(Note::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clearStale($olderThan = '-2 Days'): int
    {
        $deleted = $this
            ->get()
            ->reduce(function (int $carry, Tag $tag) use ($olderThan) {
                if ($tag->notes->isEmpty()
                    && $tag->created_at->lessThan(Carbon::make($olderThan))) {
                    return $tag->delete() ? $carry + 1 : $carry;
                }
                return $carry;
            }, 0);
        return $deleted;
    }
}
