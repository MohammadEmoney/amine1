<?php

namespace App\Livewire\Dashboard\Classes;

use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class LiveClassIndex extends Component
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
        $this->display = false;
        $this->title = "دوره ها";
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

    public function showDetails($id)
    {
        return redirect()->to(route('profile.classes.show', $id));
    }

    public function render()
    {
        $user = Auth::user();
        $semesters = Semester::query()->with(['course', 'teacher']);
        $searchTerm = preg_replace('/\s*\/\s*/', '/', trim($this->searchTerm));
        // dd($searchTerm);
        if($user->hasRole(['teacher'])){
            $semesters = $semesters->orWhereHas('teacher', function($query) use ($user){
                $query->where('id', $user->id);
            });
        }elseif(!$this->showAll){
            $semesters = $semesters->where('id', null);
        }
        
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
        return view('livewire.dashboard.classes.live-class-index', compact('semesters'))
            ->extends('layouts.panel')->section('content');
    }
}
