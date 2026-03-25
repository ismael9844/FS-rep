<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property int $id
 * @property int $donation_id
 * @property int $user_id
 * @property int $quantity_distributed
 * @property string $distribution_date
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Donation $donation
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereDistributionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereDonationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereQuantityDistributed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Distribution whereUserId($value)
 * @mixin \Eloquent
 */
class Distribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'user_id',
        'quantity_distributed',
        'distribution_date',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}

