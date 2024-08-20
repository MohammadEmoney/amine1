<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'dropout_id',
        'user_id',
        'reasons',
        'description',
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
     * Get the user that owns the FollowUp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the dropout that owns the FollowUp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dropout(): BelongsTo
    {
        return $this->belongsTo(Dropout::class);
    }
}
