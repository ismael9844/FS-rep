<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FoodRequest;



/**
 * @property int $id
 * @property int|null $food_request_id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string|null $image
 * @property int $quantity
 * @property string $unit
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property \Illuminate\Support\Carbon|null $available_until
 * @property string $status
 * @property string|null $expiration_date
 * @property int $need_volunteers
 * @property string|null $volunteer_note
 * @property string|null $category
 * @property int $min_quantity
 * @property string $donor_type
 * @property \Illuminate\Support\Carbon|null $available_from
 * @property string|null $available_to
 * @property string|null $city
 * @property string|null $postal_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $partner_id
 * @property-read FoodRequest|null $foodRequest
 * @property-read mixed $image_url
 * @property-read mixed $is_urgent
 * @property-read \App\Models\Partner|null $partner
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Volunteer> $volunteers
 * @property-read int|null $volunteers_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation available()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation notExpired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation urgent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereAvailableFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereAvailableTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereAvailableUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereDonorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereFoodRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereMinQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereNeedVolunteers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Donation whereVolunteerNote($value)
 * @mixin \Eloquent
 */
class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'quantity',
        'unit',
        'latitude',
        'longitude',
        'available_until',
        'category',
        'min_quantity',
        'donor_type',
        'available_from',
        'available_to',
        'city',
        'postal_code',
        'expiration_date',
        'partner_id',
        'need_volunteers',
        'volunteer_note',
        'status',
    ];

       protected $casts = [
        'available_until' => 'datetime',
        'available_from' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];
    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeNotExpired($query)
    {
        return $query->where(function($q){
            $q->whereNull('expiration_date')
            ->orWhere('expiration_date', '>=', now());
        });
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function volunteers()
{
    return $this->belongsToMany(
        Volunteer::class,
        'donation_volunteer',
        'donation_id',
        'volunteer_id'
    )->withPivot('volunteered_at');
}
public function foodRequest()
{
    return $this->belongsTo(FoodRequest::class);
}

// Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
                    ->where('available_until', '>', now());
    }

    public function scopeUrgent($query)
    {
        return $query->where('available_until', '<=', now()->addHours(24));
    }

    // Accesseurs
    public function getIsUrgentAttribute()
    {
        return $this->available_until <= now()->addHours(24);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
