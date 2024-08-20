<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'gender',
        'father_name',
        'birth_date',
        'landline_phone',
        'mobile_1',
        'mobile_2',
        'address',
        'job',
        'education',
        'preferd_course',
        'initial_level',
        'register_date',
        'email',
        'refferal_name',
        'refferal_national_code',
        'refferal_phone',
        'mariage_status', // 0 or null = Single, 1 = married
        'military_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // /**
    //  * @return Attribute
    //  */
    // public function registerDate(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn($value) => Jalalian::fromDateTime($value)->format('Y-m-d'),
    //     );
    // }
}
