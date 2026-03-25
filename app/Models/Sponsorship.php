<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property int $partner_id
 * @property int|null $tier_id
 * @property int $admin_id
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed>|null $images
 * @property-read \App\Models\User $admin
 * @property-read \App\Models\Partner $partner
 * @property-read \App\Models\SponsorshipTier|null $tier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereTierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsorship whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sponsorship extends Model
{
    protected $fillable = [
        'partner_id',
        'tier_id',
        'admin_id',
        'start_at',
        'end_at',
        'status',
        'images',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'images' => 'array',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function tier()
    {
        return $this->belongsTo(SponsorshipTier::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function isExpired(): bool
{
    return $this->end_at && $this->end_at->lt(now());
}   
public function images()
{
    return $this->hasMany(SponsorshipImage::class);
}

}
