<?php

namespace App\Livewire\Admin\Courses;

use App\Enums\EnumCourseAges;
use App\Enums\EnumCoursePart;
use App\Enums\EnumCourseTypes;
use App\Models\Course;
use App\Traits\AlertLiveComponent;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Str;

class LiveCourseCreate extends Component
{
    use AlertLiveComponent;

    public $disabledCreate = true;
    public $course;
    public $data = [];


    public function validations()
    {
        $this->validate(
            [
                'data.title' => 'required|string|max:255',
                'data.parent_id' => 'nullable|numeric|exists:courses,id',
                'data.course_age' => 'required|in:' . EnumCourseAges::asStringValues(),
                'data.course_type' => 'required|in:' . EnumCourseTypes::asStringValues(),
                'data.price' => 'required|min:0',
                'data.sale_price' => 'nullable|min:0',
                'data.priority' => 'nullable|min:0',
                'data.part_numbers' => 'nullable',
                'data.part_numbers.*' => 'required|in:' . EnumCoursePart::asStringValues(),
            ],
            [],
            [
                'data.title' => 'عنوان',
                'data.part_numbers' => 'پارت',
                'data.parent_id' => 'دسته بندی والد',
                'data.course_age' => 'رده سنی دوره',
                'data.course_type' => 'نوع دوره',
                'data.price' => 'قیمت اصلی دوره',
                'data.sale_price' => 'قیمت فروش دوره',
                'data.priority' => 'الویت',
            ]
        );
    }

    public function submit()
    {
        $this->authorize('course_create');
        $this->validations();
        $this->createCourse();
        $this->alert('دوره با موفقیت ایجاد شد.')->success();
        return redirect()->to(route('admin.courses.index'));
    }

    public function updated($field, $value)
    {
        if(($field === "data.sale_price" || $field === "data.price")){
            $value = preg_replace('/[^\d.]/', '', $value);
            if(is_numeric($value))
                $this->data[Str::after($field, 'data.')] = number_format($value);
        }
        $this->disabledCreate = true;
        $this->validations();
        $this->disabledCreate = false;
    }

    protected function createCourse()
    {
        $this->data['price'] = preg_replace('/[^\d.]/', '', $this->data['price'] ?? 0);
        $this->data['sale_price'] = preg_replace('/[^\d.]/', '', $this->data['sale_price'] ?? 0);
        $this->validations();
        $validate = Validator::make($this->data, [
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'priority' => 'nullable|numeric|min:0'
        ],[], [
            'price' => 'قیمت اصلی دوره',
            'sale_price' => 'قیمت فروش دوره',
            'priority' => 'قیمت فروش دوره',
        ]);
        if($validate->fails())
        {
            return $this->alert($validate->messages()->first())->error();
        }else{
            if(isset($this->data['part_numbers'])){
                foreach($this->data['part_numbers'] as $partNumber){
                    $this->storeCourse($partNumber);
                }
            }else{
                $this->storeCourse();
            }
        }
    }

    private function storeCourse($partNumber = null)
    {
        Course::create([
            'title' => $this->data['title'],
            'part_number' => $partNumber,
            'parent_id' => $this->data['parent_id'] ?? null,
            'age' => $this->data['course_age'],
            'type' => $this->data['course_type'],
            'price' => $this->data['price'],
            'sale_price' => $this->data['sale_price'] ?? 0,
            'priority' => $this->data['priority'] ?? 1,
        ]);
    }

    public function render()
    {
        $courses = Course::where('parent_id', null)->get();
        $courseAges = EnumCourseAges::getTranslatedAll();
        $courseTypes = EnumCourseTypes::getTranslatedAll();
        $courseParts = EnumCoursePart::All();
        return view('livewire.admin.courses.live-course-create', compact('courses', 'courseTypes', 'courseAges', 'courseParts'));
    }
}
