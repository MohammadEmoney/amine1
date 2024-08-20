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

class LiveQuestionEdit extends Component
{
    use AlertLiveComponent;
    use MediaTrait;
    use WithFileUploads;
    use QuestionTrait;

    public $disabledCreate = true;
    public $question;
    public $evaluation;
    public $data = [];

    public function mount(Evaluation $evaluation, Question $question)
    {
        $this->evaluation = $evaluation;
        $this->question = $question;
        $this->data['number'] = $question->number;
        $this->data['value'] = $question->value;
        $this->data['type'] = $question->type;
        $this->data['title'] = $question->title;
        $this->data['subtitle'] = $question->subtitle;
        $this->data['description'] = $question->description;
        $this->data['section'] = $question->section;
        $this->questions = $question->questions;
        $this->questionType = $question->type;
        $this->data['mainImage'] = $question->getFirstMedia('mainImage');
    }

    public function validations()
    {
        $this->validate(
            [
                'data.title' => 'required|string|min:2|max:255',
                'data.subtitle' => 'nullable|string|min:2|max:255',
                'data.section' => 'nullable|string|min:2|max:255',
                'data.description' => 'nullable|string|min:2',
                'data.value' => 'nullable|numeric|min:0',
                'data.type' => 'nullable|string|min:2|max:255',
                'data.number' => 'nullable|numeric|min:0',
                // 'data.total_value' => 'required|min:0',
                // 'data.semester_id' => 'required|exists:semesters,id',
                // 'data.description' => 'nullable|string',
            ],
            [],
            [
                'data.title' => 'عنوان سوال',
                'data.subtitle' => 'زیر عنوان',
                'data.section' => 'بخش',
                'data.description' => 'توضیحات',
                'data.value' => 'نمره',
                'data.type' => 'نوع سوال',
                'data.number' => 'شماره سوال',
            ]
        );
    }

    public function updated($field, $value)
    {
        if($field === 'data.type')
            $this->questionType = $value;
    }

    public function submit()
    {
        try {
            $this->validations();
            $this->question->update([
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

            $this->createImage($this->question);
            $this->alert('سوال با موفقیت ثبت شد.')->success();
            return redirect()->to(route('admin.questions.index', ['evaluation' => $this->evaluation]));
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
        
    }
    
    public function render()
    {
        $types = EnumQuestionType::getTranslatedAll();
        return view('livewire.admin.questions.live-question-edit', compact('types'))
            ->extends('layouts.admin-panel')->section('content');
    }
}
