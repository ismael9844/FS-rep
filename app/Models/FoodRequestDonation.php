<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $food_request_id
 * @property int $user_id
 * @property int $quantity
 * @property string $unit
 * @property string $available_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contribution> $contributions
 * @property-read int|null $contributions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $donations
 * @property-read int|null $donations_count
 * @property-read \App\Models\FoodRequest $foodRequest
 * @property-read \App\Models\User|null $organization
 * @property-read \App\Models\FoodRequest $request
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation whereAvailableUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation whereFoodRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequestDonation whereUserId($value)
 * @mixin \Eloquent
 */
class FoodRequestDonation extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_request_id',
        'user_id',
        'quantity',
        'unit',
        'available_until',
        'confirmation_token',
        'scheduled_date',
        'location',
        'latitude',
        'longitude',
        'partner_note',
        'status',
    ];

    public function request()
    {
        return $this->belongsTo(FoodRequest::class, 'food_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function donations()
    {
        return $this->hasMany(Donation::class);
    }

        public function organization()
    {
        return $this->belongsTo(User::class, 'organization_id');
    }

        public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function foodRequest() {
        return $this->belongsTo(FoodRequest::class);
    }


}
