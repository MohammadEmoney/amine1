<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobReference extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'company_name',
        'role',
        'date_start',
        'date_end',
        'still_working',
        'description',
        'work_address',
        'work_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
