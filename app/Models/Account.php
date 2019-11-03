<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Account
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Movement[] $movements
 * @property-read int|null $movements_count
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Account onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Account whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Account withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Account withoutTrashed()
 * @mixin \Eloquent
 */
class Account extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function balance()
    {
        $movements = $this->movements()->get();
        return $movements->reduce(function ($carry, Movement $movement) {
            return $carry + $movement->amount;
        }, 0);
    }
}
