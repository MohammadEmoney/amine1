<?php

namespace App\Livewire\Dashboard\Attendances;

use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class LiveAttendanceClassIndex extends Component
{
    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;
    public $searchTerm;
    public $showAll = false;
    public $disableSearchBtn = true;
    public $display;
    public $title;

    public function mount()
    {
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

    public function attendanceList($id)
    {
        return redirect()->to(route('profile.attendances.index', ['class' => $id]));
    }

    public function render()
    {
        $semesters = Semester::query()->with(['course', 'teacher'])->where('teacher_id', Auth::id());
        $searchTerm = preg_replace('/\s*\/\s*/', '/', trim($this->searchTerm));
        if($searchTerm && mb_strlen($searchTerm) > 2){
            $semesters = $semesters->whereHas('course' ,function($query) use($searchTerm){
                $query->where('title', "like", "%$searchTerm%")
                    ->orWhereRaw("CONCAT(title, '/', part_number) LIKE ?", ["%$searchTerm%"]);
            })->orWhereHas('teacher', function($query) use ($searchTerm){
                $query->where('email', 'like', "%$searchTerm%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$searchTerm%"]);
            });
        }
        $semesters = $semesters->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.dashboard.attendances.live-attendance-class-index', compact('semesters'))
            ->extends('layouts.panel')->section('content');
    }
}
