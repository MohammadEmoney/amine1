<?php

namespace App\Traits;

use App\Rules\JDate;
use Illuminate\Support\Facades\Auth;

trait DropoutTrait
{
    public $dropouts = [];

    public function dropoutRules()
    {
        $this->validate([
            'dropouts.reasons' => 'required_if:dropout,true|array',
            'dropouts.reasons.*' => 'required_if:dropout,true|string',
            'dropouts.date_left' => ['required_if:dropout,true', 'string', new JDate()],
            'dropouts.date_return' => ['nullable', 'string', new JDate()],
            'dropouts.description' => 'nullable|string',
        ],[
            'dropouts.reasons.required_if' => 'علت ریزش دانش آموز درصورتی که دکمه ریزشی فعال باشد ازامی می باشد',
            'dropouts.date_left.required_if' => 'تاریخ ترک درصورتی که دکمه ریزشی فعال باشد ازامی می باشد',
            'dropouts.date_return.required_if' => 'تاریخ بازگشت درصورتی که دکمه ریزشی فعال باشد ازامی می باشد',
            'dropouts.description.required_if' => 'توضیحات درصورتی که دکمه ریزشی فعال باشد ازامی می باشد',
        ],[
            'dropouts.reasons' => 'علت ریزش دانش آموز',
            'dropouts.date_left' => 'تاریخ ترک',
            'dropouts.date_return' => 'تاریخ بازگشت',
            'dropouts.description' => 'توضیحات',
        ]);
    }

    public function createDropout($user)
    {
        try {
            $this->dropoutRules();
            $user->dropout()->create([
                'user_id' => Auth::id(),
                'description' => $this->dropouts['description'] ?? null,
                'reasons' => $this->dropouts['reasons'] ?? null,
                'date_left' => isset($this->dropouts['date_left']) ? $this->convertToGeorgianDate($this->dropouts['date_left']) : null,
                'date_return' => isset($this->dropouts['date_return']) ? $this->convertToGeorgianDate($this->dropouts['date_return']) : null,
            ]);

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}