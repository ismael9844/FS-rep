<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $donation_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $scheduled_at
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $confirmation_token
 * @property string|null $confirmed_at
 * @property-read \App\Models\Donation $donation
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereConfirmationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereDonationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pickup whereUserId($value)
 * @mixin \Eloquent
 */
class Pickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'user_id',
        'scheduled_at',
        'status',
        'notes',
        'confirmation_token',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
