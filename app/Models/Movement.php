<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Movement
 *
 * @property int $id
 * @property int $account_id
 * @property float $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $amount_date
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account $account
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Movement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement whereAmountDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Movement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Movement withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Movement withoutTrashed()
 * @mixin \Eloquent
 */
class Movement extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount_date' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
