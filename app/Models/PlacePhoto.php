<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


/**
 * @property int $id
 * @property int $place_id
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $url
 * @property-read \App\Models\Place $place
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacePhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacePhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacePhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacePhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacePhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacePhoto wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacePhoto wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacePhoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PlacePhoto extends Model
{
    protected $fillable = ['path', 'place_id'];

    protected $appends = ['url'];

    public function place() {
        return $this->belongsTo(Place::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($photo) {
            if ($photo->path && Storage::exists($photo->path)) {
                Storage::delete($photo->path);
            }
        });
    }

      /**
     * Get the URL attribute
     */
    public function getUrlAttribute()
    {
        return $this->path; // ImgBB URL complète
    }
}

