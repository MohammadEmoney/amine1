<?php

namespace App\Livewire\Admin\Attendances;

use App\Models\Attendance;
use App\Traits\AlertLiveComponent;
use Livewire\Component;

class LiveAttendanceIndex extends Component
{
    use AlertLiveComponent;

    protected $listeners = ['destroy'];

    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;

    public function create()
    {
        return redirect()->to(route('admin.attendances.create'));
    }

    public function show($id)
    {
        return redirect()->to(route('admin.attendances.show', ['semester' => $id]));
    }

    public function destroy($id)
    {
        if(auth()->user()->can('attendance_delete')){
            $attendance = Attendance::query()->find($id);

            if ($attendance) {
                $attendance->delete();
                $this->alert('حضور غیاب حذف شد')->success();
            }
            else{
                $this->alert('حضور غیاب حذف نشد')->error();
            }
        }else{
            $this->alert('شما اجازه دسترسی به این بخش را ندارید.')->error();
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $attendances = Attendance::query();
        if($this->search && mb_strlen($this->search) > 2){
            $attendances = $attendances->where(function($query){
                $query->where('title', "like", "%$this->search%");
            });
        }
        $attendances = $attendances->groupBy('semester_id')->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.admin.attendances.live-attendance-index', compact('attendances'))->extends('layouts.admin-panel')->section('content');
    }
}
