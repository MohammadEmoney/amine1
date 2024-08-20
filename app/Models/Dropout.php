<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dropout extends Model
{
    use HasFactory, SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'student_id',
        'user_id',
        'delete_user_id',
        'reasons',
        'description',
        'date_left',
        'date_return',
        'has_returned',
        'end_follow_up',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'reasons' => 'json',
    ];

    /**
     * Get the user that owns the Dropout
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the student that owns the Dropout
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    /**
     * Get the userDelete that owns the Dropout
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userDelete(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delete_user_id');
    }

    /**
     * Get all of the followUps for the Dropout
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class);
    }
}
