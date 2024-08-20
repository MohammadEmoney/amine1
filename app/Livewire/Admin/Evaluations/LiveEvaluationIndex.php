<?php

namespace App\Livewire\Admin\Evaluations;

use App\Models\Evaluation;
use App\Traits\AlertLiveComponent;
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
        return redirect()->to(route('admin.evaluations.create'));
    }

    public function edit($id)
    {
        return redirect()->to(route('admin.evaluations.edit', $id));
    }

    public function destroy($id)
    {
        if(auth()->user()->can('evaluation_delete')){
            $evaluation = Evaluation::query()->find($id);

            if ($evaluation) {
                $evaluation->delete();
                $this->alert('سوال حذف شد')->success();
            }
            else{
                $this->alert('سوال حذف نشد')->error();
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
        $evaluations = Evaluation::latest()->withCount('questions')->paginate();
        return view('livewire.admin.evaluations.live-evaluation-index', compact('evaluations'))->extends('layouts.admin-panel')->section('content');
    }
}
