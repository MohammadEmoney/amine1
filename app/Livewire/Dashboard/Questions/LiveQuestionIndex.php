<?php

namespace App\Livewire\Dashboard\Questions;

use App\Models\Evaluation;
use App\Models\Question;
use App\Traits\AlertLiveComponent;
use Livewire\Component;

class LiveQuestionIndex extends Component
{
    use AlertLiveComponent;

    protected $listeners = ['destroy'];

    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;
    public $evaluation;

    public function mount(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
    }

    public function create()
    {
        return redirect()->to(route('profile.questions.create', ['evaluation' => $this->evaluation]));
    }

    public function edit($id)
    {
        return redirect()->to(route('profile.questions.edit', ['evaluation' => $this->evaluation, 'question' => $id]));
    }

    public function changeActiveStatus($id)
    {
        $question = Question::find($id);
        if($question){
            $question->update(['is_active' => !$question->is_active]);
            $this->alert('با موفقیت آپدیت شد.')->success();
        }
    }

    public function destroy($id)
    {
        if(auth()->user()->can('question_delete')){
            $question = Question::query()->find($id);

            if ($question) {
                $question->delete();
                $this->alert('سوال حذف شد')->success();
            }
            else{
                $this->alert('سوال حذف نشد')->error();
            }
        }else{
            $this->alert('شما اجازه دسترسی به این بخش را ندارید.')->error();
        }
    }
    
    public function render()
    {
        $questions = Question::query()->where('evaluation_id', $this->evaluation->id);
        if($this->search && mb_strlen($this->search) > 2){
            $questions = $questions->where(function($query){
                $query->where('title', "like", "%$this->search%");
            });
        }
        $questions = $questions->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.dashboard.questions.live-question-index', compact('questions'))->extends('layouts.panel')->section('content');
    }
}
