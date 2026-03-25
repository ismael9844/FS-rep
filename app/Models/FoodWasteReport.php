<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $category
 * @property int $quantity
 * @property string|null $description
 * @property numeric $latitude
 * @property numeric $longitude
 * @property string $reported_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereReportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodWasteReport whereUserId($value)
 * @mixin \Eloquent
 */
class FoodWasteReport extends Model
{
    use HasFactory;

    // Déclare les colonnes de la table qui peuvent être remplies massivement
    protected $fillable = [
        'user_id',
        'category',
        'quantity',
        'description',
        'latitude',
        'longitude',
        'reported_at',
    ];

    // Si tu utilises des timestamps personnalisés (création/édition)
    public $timestamps = true;

    // Relation avec le modèle User (si tu as un modèle User qui est lié aux rapports)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
