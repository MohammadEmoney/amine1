<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Question extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'evaluation_id',
        'number',
        'value',
        'type',
        'section',
        'title',
        'subtitle',
        'description',
        'icon',
        'questions',
        'correct_answer',
        'is_active',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'questions' => 'json',
    ];

    /**
     * Get the evaluation that owns the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('mainImage')->nonQueued();
    }

    /**
     * is active scope
     * @param Builder $query
     * @return void
     */
    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }
}
