<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $place_id
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $url
 * @property-read \App\Models\Place $place
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photo wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photo wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Photo extends Model
{
    use HasFactory;

    protected $table = 'place_photos'; // Si votre table s'appelle place_photos

    protected $fillable = [
        'path',
        'place_id'
    ];

    /**
     * Relation avec Place
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Accesseur pour générer l'URL publique automatiquement
     */
    public function getUrlAttribute()
    {
        return $this->path ? Storage::url($this->path) : null;
    }

    /**
     * Suppression automatique du fichier quand le modèle est supprimé
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($photo) {
            if ($photo->path && Storage::exists($photo->path)) {
                Storage::delete($photo->path);
            }
        });
    }
}