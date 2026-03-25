<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property numeric $price
 * @property int $duration_days
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sponsorship> $sponsorships
 * @property-read int|null $sponsorships_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tier extends Model
{
    protected $fillable = ['name', 'price', 'duration_days'];

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }

    public static function levelsOrder()
    {
        return ['Platinum', 'Gold', 'Silver', 'Bronze'];
    }
}
    