<?php

namespace App\Livewire\Admin\Dropouts;

use App\Enums\EnumDropoutReasons;
use App\Models\Dropout;
use App\Models\FollowUp;
use App\Rules\JDate;
use App\Traits\AlertLiveComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Morilog\Jalali\Jalalian;

class LiveDropoutEdit extends Component
{
    use AlertLiveComponent;

    public $dropout;
    public $title;
    public $adding = false;
    public $dropouts = [];
    public $data = [];
    public $followUps = [];

    public function mount(Dropout $dropout)
    {
        $this->dropout = $dropout;
        $this->dropouts = [
            'description' => $dropout->description,
            'reasons' => $dropout->reasons,
            'date_left' => $dropout->date_left ? Jalalian::fromDateTime($dropout->date_left)->format('Y-m-d') : null,
            'date_return' => $dropout->date_return ? Jalalian::fromDateTime($dropout->date_return)->format('Y-m-d') : null,
        ];
        $this->title = 'پیگیری دانش آموز ' . $dropout->student?->full_name;

        $followUps = [];

        foreach($dropout->followUps ?: [] as $followUp){
            $followUps[] = [
                'id' => $followUp->id,
                'description' => $followUp->description,
                'reasons' => $followUp->reasons,
                'user_id' => $followUp->user_id,
                'username' => $followUp->user?->full_name,
            ];
        }

        // $followUps = $dropout->followUps->map(function($item){

        // });

        $this->followUps = $followUps;
    }

    public function validateFollowUp()
    {
        $this->validate([
            'data.reasons' => 'required|array',
            'data.reasons.*' => 'required|string',
            'data.description' => 'nullable|string',
        ],[
        ],[
            'data.reasons' => 'علت ریزش دانش آموز',
            'data.date_left' => 'تاریخ ترک',
            'data.date_return' => 'تاریخ بازگشت',
            'data.description' => 'توضیحات',
        ]);
    }

    public function validateAll()
    {
        $this->validate([
            'followUps.*.reasons' => 'required|array',
            'followUps.*.reasons.*' => 'required|string',
            'followUps.*.description' => 'nullable|string',
        ],[
        ],[
            'followUps.*.reasons' => 'علت ریزش دانش آموز',
            'followUps.*.date_left' => 'تاریخ ترک',
            'followUps.*.date_return' => 'تاریخ بازگشت',
            'followUps.*.description' => 'توضیحات',
        ]);
    }

    public function validateDropout()
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

    public function showForm()
    {
        $this->adding = true;
        $this->dispatch('loadJs');
    }

    public function submitData()
    {
        try {
            $this->validateFollowUp();

            $this->followUps[] = [
                'description' => $this->data['description'] ?? null,
                'reasons' => $this->data['reasons'] ?? null,
                'user_id' => Auth::id(),
                'username' => Auth::user()->full_name,
            ];

            $this->data = [];
            $this->adding = false;
            $this->dispatch('loadJs');
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }

    public function submit()
    {
        try {
            $this->validateAll();

            DB::beginTransaction();

            foreach($this->followUps as $followUp){
                if(isset($followUp['id'])){
                    $model = FollowUp::find($followUp['id']);
                    if($model){
                        $model->update([
                            'reasons' => $followUp['reasons'] ?? "",
                            'description' => $followUp['description'] ?? "",
                            'user_id' => Auth::id(),
                            'dropout_id' => $this->dropout->id,
                        ]);
                    }
                }else{
                    FollowUp::create([
                        'reasons' => $followUp['reasons'] ?? "",
                        'description' => $followUp['description'] ?? "",
                        'user_id' => Auth::id(),
                        'dropout_id' => $this->dropout->id,
                    ]);

                }
            }

            $this->followUps = [];
            DB::commit();
            $this->alert('پیگیری با موفقیت ثبت شد.')->success();
            return redirect()->to(route('admin.users.dropouts.index'));
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }

    public function render()
    {
        $dropoutReasons = EnumDropoutReasons::getTranslatedAll();
        return view('livewire.admin.dropouts.live-dropout-edit', compact('dropoutReasons'))
            ->extends('layouts.admin-panel')
            ->section('content');
    }
}
