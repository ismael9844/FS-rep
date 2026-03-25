<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property array<array-key, mixed>|null $preferred_categories
 * @property int $min_quantity
 * @property int $max_distance
 * @property string|null $available_from
 * @property string|null $available_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference whereAvailableFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference whereAvailableUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference whereMaxDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference whereMinQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference wherePreferredCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPreference whereUserId($value)
 * @mixin \Eloquent
 */
class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'preferred_categories',
        'min_quantity',
        'max_distance',
        'available_from',
        'available_until',
    ];

    protected $casts = [
        'preferred_categories' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
