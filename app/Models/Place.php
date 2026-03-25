<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string $address
 * @property string|null $google_maps_link
 * @property string $contact_info
 * @property string|null $availability
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PlacePhoto> $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PlaceRequest> $requests
 * @property-read int|null $requests_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereContactInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereGoogleMapsLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Place whereUserId($value)
 * @mixin \Eloquent
 */
class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'address', 'google_maps_link', 'contact_info', 'availability'
    ];

    // Le propriétaire du lieu
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Les photos attachées au lieu
    public function photos()
    {
        return $this->hasMany(PlacePhoto::class);
        
    }

    // Les demandes faites pour ce lieu
    public function requests()
    {
        return $this->hasMany(PlaceRequest::class);
    }
}
