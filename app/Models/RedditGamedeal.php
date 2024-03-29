<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RedditGamedeal
 *
 * @property int $id
 * @property string $title
 * @property string $permalink
 * @property string $storeLink
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal wherePermalink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal whereStoreLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RedditGamedeal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RedditGamedeal extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'permalink', 'storeLink'];
}
