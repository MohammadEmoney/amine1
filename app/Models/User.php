<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, InteractsWithMedia, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'national_code',
        'email',
        'phone',
        'email_verified_at',
        'phone_verified_at',
        'password',
        'otp_code',
        'register_complete',
        'is_foreigner',
        'settings',
    ];

    /**
     * Perform pre-authorization checks on the model.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null; // see the note above in Gate::before about why null must be returned here.
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
        'settings' => 'json',
    ];

    /**
     * Get the user's first name.
     */
    protected function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function jobReferences()
    {
        return $this->hasMany(JobReference::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('national_card')
            // ->fit(Fit::Contain, 300, 300)
            ->nonQueued();

        $this->addMediaConversion('personal_image')->nonQueued();
        $this->addMediaConversion('id_first_page')->nonQueued();
        $this->addMediaConversion('id_second_page')->nonQueued();
        $this->addMediaConversion('document_1')->nonQueued();
        $this->addMediaConversion('document_2')->nonQueued();
        $this->addMediaConversion('document_3')->nonQueued();
        $this->addMediaConversion('document_4')->nonQueued();
        $this->addMediaConversion('document_5')->nonQueued();
        $this->addMediaConversion('document_6')->nonQueued();
        $this->addMediaConversion('document_7')->nonQueued();
        $this->addMediaConversion('document_8')->nonQueued();
    }

    /**
     * Get all of the reportCards for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reportCards(): HasMany
    {
        return $this->hasMany(ReportCard::class);
    }

    /**
     * The semesters that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function semesters(): BelongsToMany
    {
        return $this->belongsToMany(Semester::class, 'semester_user', 'user_id', 'semester_id')->withPivot('current', 'class_number');
    }

    public function getCurrentSemesterTitleAttribute()
    {
        $semester = $this->semesters()->latest()->wherePivot('current', true)?->first() ?? null;
        if($semester)
            return $semester->course?->title . ($semester->part_number ? "/ $semester->part_number" : "");
        return "-";
    }

    public function getCurrentSemesterTeacherAttribute()
    {
        $semester = $this->semesters()->latest()->wherePivot('current', true)?->first() ?? null;
        if($semester)
            return $semester->teacher?->full_name ?: '-';
        return "-";
    }

    /**
     * Get all of the orders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all of the carts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    // public function scopeLatestOrder(Builder $query,$type)
    // {
    //     return $query->orders()->where('type', $type)->first();
    // }

    public function scopeDropout(Builder $query)
    {
        return $query->whereHas('dropout');
    }

    public function scopeNotDropout(Builder $query)
    {
        return $query->whereDoesntHave('dropout');
    }

    /**
     * The attendances that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attendances(): BelongsToMany
    {
        return $this->belongsToMany(Attendance::class, 'attendance_user', 'user_id', 'attendance_id');
    }

    /**
     * Get the dropout associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dropout(): HasOne
    {
        return $this->hasOne(Dropout::class, 'student_id');
    }

    /**
     * Get all of the dropouts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dropouts(): HasMany
    {
        return $this->hasMany(Dropout::class, 'user_id');
    }

    /**
     * Get all of the followUps for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }
}
