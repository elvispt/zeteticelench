<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HackerNewsItemsBookmark
 *
 * @property int $id
 * @property int $hacker_news_item_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItemsBookmark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItemsBookmark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItemsBookmark query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItemsBookmark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItemsBookmark whereHackerNewsItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItemsBookmark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItemsBookmark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItemsBookmark whereUserId($value)
 * @mixin \Eloquent
 */
class HackerNewsItemsBookmark extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
