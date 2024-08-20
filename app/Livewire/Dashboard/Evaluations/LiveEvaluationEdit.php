<?php

namespace App\Livewire\Dashboard\Evaluations;

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
            $evaluation =  Evaluation::create([
                'user_id' => Auth::id(),
                'semester_id' => $this->data['semester_id'],
                // 'season' => $this->data['season'] ?? null,
                // 'answer_key' => $this->data['answer_key'],
                'type' => EnumEvaluationType::GENERAL,
                'total_value' => $this->data['total_value'] ?? 0,
            ]);

            $this->createEvaluationImage($evaluation);
            $this->alert('سوال با موفقیت ثبت شد.')->success();
            return redirect()->to(route('profile.questions.index'));
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
        
    }
    
    public function render()
    {
        $semesters = Semester::with(['course', 'teacher'])->get();
        return view('livewire.dashboard.evaluations.live-evaluation-edit', compact('semesters'))
            ->extends('layouts.panel')->section('content');
    }
}
