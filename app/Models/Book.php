<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Book extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'title',
        'price',
        'sale_price',
        'age',
        'description',
        'is_active',
        'inventory',
    ];

    public function order()
    {
        return $this->morphMany(Order::class, 'orderable');
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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('mainImage')->nonQueued();
    }

    public function cart()
    {
        return $this->morphOne(Cart::class, 'cartable');
    }
}
