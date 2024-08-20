<?php

namespace App\Livewire\Dashboard\Classes;

use App\Models\Semester;
use App\Models\User;
use App\Traits\AlertLiveComponent;
use Livewire\Component;

class LiveStudentIndex extends Component
{
    use AlertLiveComponent;
    
    protected $listeners = ['destroy'];

    public $semester;
    public $data = [];
    public $add = false;

    public function mount(Semester $semester)
    {
        $this->semester = $semester;
    }

    public function enableAdd()
    {
        $this->add = true;
        $this->dispatch('select2Initiation');
    }

    public function submit()
    {
        $this->add = false;
        $this->semester->students()->attach($this->data['selected_students'] ?? [], ['class_number' => $this->semester->class_number]);
        $this->alert('با موفقیت اضافه شد.')->success();
    }

    public function destroy($id)
    {
        $this->semester->students()->detach($id);
        $this->alert('با موفقیت حذف شد.')->success();
    }

    public function render()
    {
        $students = $this->semester->students;
        $allStudents = User::with(['userInfo', 'dropout'])
            ->whereNotIn('id', $students->pluck('id'))
            ->notDropout()->whereRelation('userInfo', 'type', 'student')->get();
        return view('livewire.dashboard.classes.live-student-index', compact('students', 'allStudents'))
            ->extends('layouts.panel')->section('content');
    }
}
