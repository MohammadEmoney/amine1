<?php

namespace App\Livewire\Admin\Messages;

use App\Enums\EnumMessageStatus;
use App\Models\Message;
use App\Models\Semester;
use App\Models\User;
use App\Traits\AlertLiveComponent;
use Livewire\Component;

class LiveMessageCreate extends Component
{
    use AlertLiveComponent;

    public $disabledCreate = true;
    public $isClass = true;
    public $message;
    public $data = [];

    public function mount()
    {
        $this->isClass = request()->segment(3) === 'class' ? true : false;
    }

    public function validations()
    {
        $this->validate(
            [
                'data.title' => 'required|string|min:2|max:255',
                'data.message' => 'required|string|min:4',
                'data.students' => 'nullable|array',
            ],
            [],
            [
                'data.title' => 'عنوان',
                'data.message' => 'پیام',
                'data.students' => 'دانش آموزان',
            ]
        );
    }

    public function updated($field, $value)
    {
        
        $this->disabledCreate = true;
        $this->validations();
        $this->disabledCreate = false;
    }

    public function submit()
    {
        $this->create('sent');
    }

    public function draft()
    {
        $this->create();
    }

    protected function create($type = 'draft')
    {
        try {
            $this->validations();
            $message =  Message::create([
                'title' => $this->data['title'],
                'message' => $this->data['message'],
                'status' => $type === 'draft' ? EnumMessageStatus::DRAFT : EnumMessageStatus::SENT,
            ]);

            if($this->isClass){
                $semester  = Semester::find($this->data['semesters']);
                $students = $semester->students->pluck('id');
            }else{
                $students = $this->data['students'];
            }

            $message->users()->attach($students);
            $response =  $type === 'draft' ? 'پیام با موفقیت ثبت شد.' : 'پیام با موفقیت ارسال شد.';
            $this->alert($response)->success();
            return redirect()->to(route('admin.messages.index'));
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }
    
    public function render()
    {
        $users = User::with(['userInfo'])->whereRelation('userInfo', 'type', 'student')->get();
        $semesters = Semester::with(['course', 'teacher'])->get();
        return view('livewire.admin.messages.live-message-create', compact('users', 'semesters'))->extends('layouts.admin-panel')->section('content');
    }
}
