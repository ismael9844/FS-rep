<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property numeric $price
 * @property int $duration_days
 * @property array<array-key, mixed>|null $features
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sponsorship> $sponsorships
 * @property-read int|null $sponsorships_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SponsorshipTier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SponsorshipTier extends Model
{
    protected $fillable = ['name','price','duration_days','features'];

    protected $casts = [
        'features' => 'array',
    ];

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class, 'tier_id');
    }
}
    