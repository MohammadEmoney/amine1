<?php

namespace App\Livewire\Dashboard\Evaluations;

use App\Models\Evaluation;
use App\Traits\AlertLiveComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveEvaluationIndex extends Component
{
    use AlertLiveComponent;

    protected $listeners = ['destroy'];

    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;

    public function create()
    {
        return redirect()->to(route('profile.evaluations.create'));
    }

    public function edit($id)
    {
        return redirect()->to(route('profile.evaluations.edit', $id));
    }

    public function destroy($id)
    {
        $evaluation = Evaluation::query()->where('user_id', Auth::id())->where('id', $id)->first();
        if($evaluation){
            $evaluation->delete();
            $this->alert('سوال حذف شد')->success();
        }else{
            $this->alert('شما اجازه دسترسی به این بخش را ندارید.')->error();
        }
    }
    
    public function render()
    {
        $evaluations = Evaluation::where('user_id', Auth::id())->withCount('questions')->latest()->paginate();
        return view('livewire.dashboard.evaluations.live-evaluation-index', compact('evaluations'))->extends('layouts.panel')->section('content');
    }
}
