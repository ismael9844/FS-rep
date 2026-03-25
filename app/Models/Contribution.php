<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $partner_id
 * @property int $food_request_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FoodRequest $foodRequest
 * @property-read \App\Models\User $partner
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution whereFoodRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contribution whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'food_request_id',
        'amount',
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function foodRequest()
    {
        return $this->belongsTo(FoodRequest::class);
    }
        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
