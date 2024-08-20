<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'sku',
        'image',
        'real_price',
        'sales_price',
        'active',
        'inventory',
        'views',
        'created_by',
        'updated_by',
        'published_at',
        'type',
    ];
}
