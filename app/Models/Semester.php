<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'course_id',
        'teacher_id',
        'gender',
        'class_number',
        'term_number',
        'tuition_fee',
        'register_date',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'week_days',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        "week_days" => "json",
        'time_start' => 'datetime:H:i',
        'time_end' => 'datetime:H:i',
    ];

    /**
     * The users that belong to the Semester
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'semester_user', 'semester_id', 'user_id')->withPivot('current', 'class_number');
    }

    /**
     * Get the course that owns the Semester
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the teacher that owns the Semester
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get all of the attendances for the Semester
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function order()
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    public function cart()
    {
        return $this->morphOne(Cart::class, 'cartable');
    }

    public function getTitleAttribute()
    {
        return $this->course?->title_with_part ?: "-";
    }

    public function getPriceAttribute()
    {
        return $this->tuition_fee;
    }

    public function getDaysAttribute()
    {
        $days = $this->week_days['days'] ?? [];
        $filteredData = collect($days)
        ->filter(function ($value) {
            return $value;
        })
        ->map(function ($value, $key) {
            return trans('admin/globals.week_days.' . $key);
        })
        ->implode(' - ');
        return $filteredData;
    }

    public function getDayTypeAttribute()
    {
        return isset($this->week_days['type']) ?  trans('admin/globals.week_types.' . $this->week_days['type']) : "";
    }

    public function hasClassToday($day)
    {
        $days = $this->week_days['days'] ?? [];
        $filteredData = collect($days)
        ->filter(function ($value) {
            return $value;
        })
        ->map(function ($value, $key) {
            return trans('admin/globals.week_days.' . $key);
        });
        return $filteredData->get($day);
    }
}
