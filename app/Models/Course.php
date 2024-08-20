<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Course extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'title',
        'part_number',
        'price',
        'sale_price',
        'parent_id',
        'age', // Youth, Children, adult,
        'type', // Private, Public
        'is_active',
        'priority',
    ];

    public function getTitleWithPartAttribute()
    {
        $part = $this->part_number ? " / $this->part_number" : "";
        return $this->title . $part;
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function scopeNotActive($query)
    {
        $query->where('is_active', 0);
    }
}

