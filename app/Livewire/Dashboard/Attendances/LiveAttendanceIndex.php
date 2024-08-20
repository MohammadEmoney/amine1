<?php

namespace App\Livewire\Dashboard\Attendances;

use App\Models\Attendance;
use App\Models\Question;
use App\Models\Semester;
use App\Traits\AlertLiveComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class LiveAttendanceIndex extends Component
{
    use AlertLiveComponent;

    protected $listeners = ['destroy'];

    public $paginate = 10;
    public $sort = 'date';
    public $sortDirection = 'DESC';
    public $search;
    public $searchTerm;
    public $showAll = true;
    public $disableSearchBtn = true;
    public $display;
    public $title;
    public $semester;

    public function mount(Semester $class)
    {
        $this->semester = $class;
        $this->display = true;
        $this->title = "حضور غیاب";
        Config::set('app.name', $this->title);
    }

    public function displayAll()
    {
        $this->search = null;
        $this->searchTerm = null;
        $this->showAll = true;
        $this->disableSearchBtn = true;
        $this->display = true;
    }

    public function submit()
    {
        $this->searchTerm = $this->search;
        $this->display = true;
    }

    public function updatedSearch($value)
    {
        if($value > 0)
            $this->disableSearchBtn = false;
        else
            $this->disableSearchBtn = true;
    }

    public function create()
    {
        return redirect()->to(route('profile.attendances.create', ['class' => $this->semester->id]));
    }

    public function edit($id)
    {
        return redirect()->to(route('profile.attendances.edit', $id));
    }

    public function changeActiveStatus($id)
    {
        $attendance = Attendance::find($id);
        if($attendance){
            $attendance->update(['is_active' => !$attendance->is_active]);
            $this->alert('با موفقیت آپدیت شد.')->success();
        }
    }

    public function destroy($id)
    {
        // if(auth()->user()->can('attendance_delete')){
            $attendance = Attendance::query()->find($id);

            if ($attendance) {
                $attendance->delete();
                $this->alert('حضورغیاب حذف شد')->success();
            }
            else{
                $this->alert('حضورغیاب حذف نشد')->error();
            }
        // }else{
        //     $this->alert('شما اجازه دسترسی به این بخش را ندارید.')->error();
        // }
    }
    
    public function render()
    {
        $attendances = Attendance::query()->where('semester_id', $this->semester->id)->where('user_id', Auth::id());
        $searchTerm = preg_replace('/\s*\/\s*/', '/', trim($this->searchTerm));
        // dd($searchTerm);
        // if(!$this->showAll)
        //     $attendances = $attendances->where('id', null);
        if($searchTerm && mb_strlen($searchTerm) > 2){
            $attendances = $attendances->whereHas('semester.course' ,function($query) use($searchTerm){
                $query->where('title', "like", "%$searchTerm%")
                        ->orWhereRaw("CONCAT(title, '/', part_number) LIKE ?", ["%$searchTerm%"]);
            });
        }
        $attendances = $attendances->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.dashboard.attendances.live-attendance-index', compact('attendances'))->extends('layouts.panel')->section('content');
    }
}
