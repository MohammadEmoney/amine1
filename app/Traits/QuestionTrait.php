<?php

namespace App\Traits;

use App\Models\Question;

trait QuestionTrait
{
    public $haveQuestion = false;
    public $editPage = false;
    public $questions = [];
    public $tempQuestions = [];
    public $editingQuestionId;
    public $questionsDatePicker;
    public $questionType;
    public $stillWorking = false;

    // public function mountQuestionsTrait()
    // {
    //     $this->questions['still_working'] = 0;
    // }

    public function addQuestion()
    {
        // $this->questionsValidation();
        // $this->tempQuestions[] = $this->questions;
        $this->questions[] = [
            'number' => count($this->questions) +1,
            'title' => '',
        ];
        // $this->loadDatePicker();
    }

    public function deleteQuestion($key)
    {
        unset($this->questions[$key]);
    }

    public function deleteChoice($questionKey, $choiceKey)
    {
        unset($this->questions[$questionKey]['choices'][$choiceKey]);
    }

    public function editQuestion($key)
    {
        $this->questions = $this->tempQuestions[$key];
        $this->editingQuestionId = $key;
    }

    public function updateQuestion()
    {
        $this->questionsValidation();
        $this->tempQuestions[$this->editingQuestionId] = $this->questions;
        $this->questions = [];
        $this->editingQuestionId = null;
        $this->loadDatePicker();
    }

    public function loadDatePicker()
    {
        $this->dispatch('selectQuestionsReference');
    }

    public function questionsValidation()
    {
        // dd($this->questions);
        $this->validate([
            'questions.company_name' => 'required|string|max:255',
            'questions.role' => 'required|string|max:255',
            'questions.description' => 'nullable|string',
            'questions.work_phone' => 'nullable|numeric',
            'questions.work_address' => 'nullable|string',
            'questions.still_working' => 'nullable|boolean',
        ],[
            'questions.date_end.required_without' => 'پایان کار الزامی است'
        ],[
            'questions.company_name' => 'نام شرکت',
            'questions.role' => 'عنوان شغلی',
            'questions.date_start' => 'شروع کار',
            'questions.date_end' => 'پایان کار',
            'questions.description' => 'توضیحات',
            'questions.work_address' => 'آدرس محل کار',
            'questions.work_phone' => 'شماره تلفن محل کار',
            'questions.still_working' => 'مشغول به کار',
        ]);
    }

    public function saveQuestions($user)
    {
        foreach($this->tempQuestions as $question){
            $stillWorking = $question['still_working'] ?? 0;
            $user->questionReferences()->create([
                'company_name' => $question['company_name'],
                'role' => $question['role'],
                'date_start' => isset($question['date_start']) ? $this->convertToGeorgianDate($question['date_start']) : null,
                'date_end' => $stillWorking ? null :  (isset($question['date_end']) ? $this->convertToGeorgianDate($question['date_end']) : null),
                'description' => $question['description'] ?? null,
                'still_working' => $stillWorking,
                'work_phone' => $question['work_phone'] ?? null,
                'work_address' => $question['work_address'] ?? null,
            ]);
        }
    }

    public function updateQuestions($user)
    {
        foreach($this->tempQuestions as $key => $question){
            $question = Question::where('id', $key)->where('user_id', $this->user->id)->first();
            if($question){
                $question->update([
                    'company_name' => $question['company_name'],
                    'role' => $question['role'],
                    'date_start' => isset($question['date_start']) ? $this->convertToGeorgianDate($question['date_start']) : null,
                    'date_end' => isset($question['date_end']) ? $this->convertToGeorgianDate($question['date_end']) : null,
                    'description' => $question['description'] ?? null,
                ]);
            }else{
                $user->questionReferences()->create([
                    'company_name' => $question['company_name'],
                    'role' => $question['role'],
                    'date_start' => isset($question['date_start']) ? $this->convertToGeorgianDate($question['date_start']) : null,
                    'date_end' => isset($question['date_end']) ? $this->convertToGeorgianDate($question['date_end']) : null,
                    'description' => $question['description'] ?? null,
                ]);
            }

        }
    }

    public function addChoice($key)
    {
        $lastInput = isset($this->questions[$key]['choices']) ? end($this->questions[$key]['choices']) : [];
        $this->questions[$key]['choices'][] = [
            'id' => count($this->questions[$key]['choices'] ?? []) ? $this->nextAlphabet($lastInput['id'] ?? 'a') : 'a',
            'title' => '',
        ];
    }

    public function nextAlphabet($letter)
    {
        return chr(ord($letter) + 1);
    }
}