<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $place_id
 * @property int $user_id
 * @property string $status
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Place $place
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceRequest whereUserId($value)
 * @mixin \Eloquent
 */
class PlaceRequest extends Model
{
    protected $fillable = ['user_id', 'place_id', 'message', 'status', 'created_at', 'updated_at','confirmation_token'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function place() {
        return $this->belongsTo(Place::class);
    }
}
