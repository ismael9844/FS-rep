<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PartnerLevelUp;
use App\Models\Contribution; // Ensure this exists

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $document_path
 * @property string|null $document_request_token
 * @property string|null $document_request_expires_at
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property string|null $address
 * @property string $status
 * @property string|null $sponsor_level
 * @property int $level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property string|null $role
 * @property int|null $linked_partner_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Contribution> $contributions
 * @property-read int|null $contributions_count
 * @property-read \App\Models\Sponsorship|null $currentSponsorship
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $donations
 * @property-read int|null $donations_count
 * @property-read string|null $document_url
 * @property-read \App\Models\Sponsorship|null $sponsorship
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sponsorship> $sponsorships
 * @property-read int|null $sponsorships_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereDocumentRequestExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereDocumentRequestToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereLinkedPartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereSponsorLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Partner whereUserId($value)
 * @mixin \Eloquent
 */
class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',         // link to users table
        'name',
        'type',
        'contact_email',
        'contact_phone',
        'address',
        'status',
        'level',
        'document_path',  
         'role', 
         'sponsor_level', 
    ];

    /**
     * A Partner belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A Partner has many Donations.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Accessor to get the public URL of the uploaded document.
     */
    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document_path
            ? Storage::url($this->document_path)
            : null;
    }

    /**
     * Recalculate and update the partner's level based on donation count.
     * Notifies the user if the level changes.
     */
    public function updateLevel(): void
    {
        $count = $this->donations()->count();
        $newLevel = min(floor($count / 10) + 1, 10);

        if ($this->level === $newLevel) {
            return;
        }

        $this->level = $newLevel;
        $this->save();

        // Notify the user that their partner level increased
        $this->user->notify(new PartnerLevelUp($newLevel));
    }
    public function contributions()
{
    return $this->hasMany(Contribution::class, 'partner_id');
}
public function organization()
{
    return $this->belongsTo(Organization::class);
}
public function sponsorships()
{
    return $this->hasMany(\App\Models\Sponsorship::class);
}
public function sponsorship()
{
    return $this->hasOne(Sponsorship::class)->where('status', 'active');
}
public function currentSponsorship()
    {
        return $this->hasOne(\App\Models\Sponsorship::class)
                    ->where('status','active')
                    ->where('end_at','>', now());
    }
     public function getCurrentTier()
    {
        return $this->sponsorships()
                    ->where('status', 'approved')
                    ->latest()
                    ->first()?->tier;
    }   

}
