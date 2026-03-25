<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FoodRequestDonation;

/**
 * @property int $id
 * @property int $organization_id
 * @property string $title
 * @property string|null $description
 * @property int|null $quantity
 * @property numeric|null $target_amount
 * @property string|null $needed_before
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $paypal_link
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contribution> $contributions
 * @property-read int|null $contributions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $donations
 * @property-read int|null $donations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FoodRequestDonation> $foodRequestDonations
 * @property-read int|null $food_request_donations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FoodRequestDonation> $food_request_donations
 * @property-read \App\Models\User $organization
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereNeededBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest wherePaypalLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereTargetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FoodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'quantity',
        'target_amount',
        'needed_before',
        'paypal_link',
        'confirmation_token',
        'scheduled_date',
        'location',
        'latitude',
        'longitude',
        'partner_note',
        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(User::class, 'organization_id');
    }

    public function user()
    {
        return $this->organization();
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }


    public function food_request_donations() {
        return $this->hasMany(FoodRequestDonation::class);
    }

    public function foodRequestDonations()
{
    return $this->hasMany(FoodRequestDonation::class);
}

}
