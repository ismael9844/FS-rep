<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $phone
 * @property string|null $skills
 * @property string|null $availability
 * @property string|null $document_path
 * @property string $verification_status
 * @property string|null $verification_note
 * @property string|null $verification_requested_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $donations
 * @property-read int|null $donations_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereVerificationNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereVerificationRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Volunteer whereVerificationStatus($value)
 * @mixin \Eloquent
 */
class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'skills',
        'availability',
    'document_path',
    'verification_status',
    'verification_note',
    'verification_requested_at',        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
{
    return $this->belongsToMany(
        Donation::class,
        'donation_volunteer',
        'volunteer_id',
        'donation_id'
    )->withPivot('volunteered_at');
}

}
