<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Donation;
use App\Models\UserPreference;
use App\Models\Partner;
use App\Controller\PartnerController;
use App\Controller\ProfileController;
use App\Models\Place;
use Illuminate\Database\Eloquent\Relations\HasOne;
USE Illuminate\Database\Eloquent\Relations\HasMany;








/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $document_path
 * @property string|null $document_request_token
 * @property string|null $document_request_expires_at
 * @property string|null $profile_image
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $real_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contribution> $contributions
 * @property-read int|null $contributions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Donation> $donations
 * @property-read int|null $donations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FoodRequest> $foodRequests
 * @property-read int|null $food_requests_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Partner|null $partner
 * @property-read Partner|null $partnerProfile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PartnerRequest> $partnerRequestsSent
 * @property-read int|null $partner_requests_sent_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Place> $places
 * @property-read int|null $places_count
 * @property-read UserPreference|null $preference
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Volunteer|null $volunteer
 * @property-read \App\Models\Volunteer|null $volunteerProfile
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDocumentRequestExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDocumentRequestToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRealName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function preference()
    {
        return $this->hasOne(UserPreference::class);
    }


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function partnerProfile(): HasOne
    {
        return $this->hasOne(Partner::class, 'user_id');
    }

    public function volunteerProfile()
    {
        return $this->hasOne(Volunteer::class, 'user_id');
    }

    public function partner()
{
    return $this->hasOne(Partner::class, 'user_id', 'id');
}

    public function foodRequests()
    {
        return $this->hasMany(FoodRequest::class, 'organization_id');
    }

        public function contributions()
    {
        return $this->hasMany(Contribution::class, 'partner_id');
    }

    public function partnerRequestsSent()
{
    return $this->hasMany(PartnerRequest::class, 'user_id')
                ->where('status', 'approved');
}
public function volunteer()
{
    return $this->hasOne(\App\Models\Volunteer::class);
}

public function places(): HasMany
{
    return $this->hasMany(Place::class);
}
}
