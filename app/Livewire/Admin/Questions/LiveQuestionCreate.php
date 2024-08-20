<?php

namespace App\Livewire\Admin\Questions;

use App\Enums\EnumQuestionType;
use App\Models\Evaluation;
use App\Models\Question;
use App\Traits\AlertLiveComponent;
use App\Traits\MediaTrait;
use App\Traits\QuestionTrait;
use Livewire\Component;
use Livewire\WithFileUploads;

class LiveQuestionCreate extends Component
{
    use AlertLiveComponent;
    use MediaTrait;
    use WithFileUploads;
    use QuestionTrait;

    public $disabledCreate = true;
    public $question;
    public $evaluation;
    public $data = [];

    public function mount(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
        $this->data['number'] = $evaluation->questions()->count() + 1;
    }

    public function validations()
    {
        $this->validate(
            [
                'data.title' => 'required|string|min:2|max:255',
                // 'data.total_value' => 'required|min:0',
                // 'data.semester_id' => 'required|exists:semesters,id',
                // 'data.description' => 'nullable|string',
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
        if($field === 'data.type')
            $this->questionType = $value;
        $this->disabledCreate = true;
        $this->validations();
        $this->disabledCreate = false;
    }

    public function submit()
    {
        try {
            $this->validations();
            $question =  Question::create([
                'evaluation_id' => $this->evaluation->id,
                'number' => $this->data['number'],
                'value' => $this->data['value'],
                'type' => $this->data['type'],
                'title' => $this->data['title'] ?? null,
                'subtitle' => $this->data['subtitle'] ?? null,
                'section' => $this->data['section'] ?? null,
                'description' => $this->data['description'] ?? null,
                'icon' => $this->data['icon'] ?? null,
                'questions' => $this->questions
            ]);

            $this->createImage($question);
            $this->createImage($question, 'audio');
            $this->alert('سوال با موفقیت ثبت شد.')->success();
            return redirect()->to(route('admin.questions.index', ['evaluation' => $this->evaluation]));
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
        
    }
    
    public function render()
    {
        $types = EnumQuestionType::getTranslatedAll();
        return view('livewire.admin.questions.live-question-create', compact('types'))
            ->extends('layouts.admin-panel')->section('content');
    }
}
