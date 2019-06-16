<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\HackerNewsItem
 *
 * @property int $id
 * @property string $type The type of item. One of "job", "story", "comment", "poll", or "pollopt".
 * @property int|null $parent_id The comment's parent: either another comment or the relevant story.
 * @property string|null $by The username of the item's author.
 * @property int $score The story's score, or the votes for a pollopt.
 * @property int $descendants In the case of stories or polls, the total comment count.
 * @property string|null $title The title of the story, poll or job.
 * @property string|null $text The comment, story or poll text. HTML.
 * @property string|null $url The URL of the story.
 * @property array|null $kids The ids of the item's comments, in ranked display order.
 * @property bool $dead true if the item is dead.
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HackerNewsItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereDead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereDescendants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereKids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HackerNewsItem whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HackerNewsItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\HackerNewsItem withoutTrashed()
 * @mixin \Eloquent
 */
class HackerNewsItem extends Model
{
    use SoftDeletes;

    protected $casts = [
        'kids' => 'array',
        'dead' => 'boolean',
    ];
}
