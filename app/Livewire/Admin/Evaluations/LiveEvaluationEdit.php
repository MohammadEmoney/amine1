<?php

namespace App\Livewire\Admin\Evaluations;

use App\Enums\EnumEvaluationType;
use App\Models\Evaluation;
use App\Models\Semester;
use App\Traits\AlertLiveComponent;
use App\Traits\MediaTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveEvaluationEdit extends Component
{
    use AlertLiveComponent;
    use MediaTrait;
    use WithFileUploads;

    public $disabledCreate = true;
    public $evaluation;
    public $data = [];

    public function mount(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
        $this->data['title'] = $evaluation->title; 
        $this->data['semester_id'] = $evaluation->semester_id; 
        $this->data['total_value'] = $evaluation->total_value; 
        $this->data['description'] = $evaluation->description; 
        $this->data['manImage'] = $evaluation->getFirstMedia('mainImage'); 
    }

    public function validations()
    {
        $this->validate(
            [
                'data.title' => 'required|string|min:2|max:255',
                'data.total_value' => 'required|min:0',
                'data.semester_id' => 'required|exists:semesters,id',
                'data.description' => 'nullable|string',
            ],
            [],
            [
                'data.title' => 'عنوان سوال',
                'data.total_value' => 'نمره کل',
                'data.semester_id' => 'کلاس',
                'data.description' => 'توضیحات',
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
        try {
            $this->validations();
            $this->evaluation->update([
                'title' => $this->data['title'] ?? null,
                'description' => $this->data['description'] ?? null,
                'semester_id' => $this->data['semester_id'],
                'total_value' => $this->data['total_value'] ?? 0,
            ]);

            $this->createImage($this->evaluation);
            $this->alert('سوال با موفقیت ثبت شد.')->success();
            return redirect()->to(route('admin.questions.index'));
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
        
    }
    
    public function render()
    {
        $semesters = Semester::with(['course', 'teacher'])->get();
        return view('livewire.admin.evaluations.live-evaluation-edit', compact('semesters'))
            ->extends('layouts.admin-panel')->section('content');
    }
}
