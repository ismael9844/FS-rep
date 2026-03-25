<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $partner_id
 * @property int $user_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Partner $partner
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PartnerRequest whereUserId($value)
 * @mixin \Eloquent
 */
class PartnerRequest extends Model
{
    use HasFactory;

    protected $fillable = ['partner_id', 'user_id', 'status']; // Définis les champs à remplir

    // Si tu veux que la demande de partenariat appartienne à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Si tu veux que la demande de partenariat appartienne à un partenaire
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}
