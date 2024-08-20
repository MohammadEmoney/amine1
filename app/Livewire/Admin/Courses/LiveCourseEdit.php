<?php

namespace App\Livewire\Admin\Courses;

use App\Enums\EnumCourseAges;
use App\Enums\EnumCoursePart;
use App\Enums\EnumCourseTypes;
use App\Models\Course;
use App\Traits\AlertLiveComponent;
use Livewire\Component;
use Illuminate\Support\Str;

class LiveCourseEdit extends Component
{
    use AlertLiveComponent;

    public $course;
    public $data = [];

    public function mount()
    {
        $this->data['title'] = $this->course->title;
        $this->data['part_number'] = $this->course->part_number;
        $this->data['parent_id'] = $this->course->parent_id;
        $this->data['course_age'] = $this->course->age;
        $this->data['course_type'] = $this->course->type;
        $this->data['priority'] = $this->course->priority;
        $this->data['price'] = number_format($this->course->price);
        $this->data['sale_price'] =  number_format($this->course->sale_price);
    }

    public function updated($field, $value)
    {
        if(($field === "data.sale_price" || $field === "data.price")){
            $value = preg_replace('/[^\d.]/', '', $value);
            if(is_numeric($value))
                $this->data[Str::after($field, 'data.')] = number_format($value);
        }
    }

    public function submit()
    {
        $this->authorize('course_edit');
        $this->data['price'] = preg_replace('/[^\d.]/', '', $this->data['price']);
        $this->data['sale_price'] = preg_replace('/[^\d.]/', '', $this->data['sale_price'] ?? 0);
        $this->validate(
            [
                'data.title' => 'required|string|max:255',
                'data.parent_id' => 'nullable|numeric|exists:courses,id',
                'data.course_age' => 'required|in:' . EnumCourseAges::asStringValues(),
                'data.course_type' => 'required|in:' . EnumCourseTypes::asStringValues(),
                'data.price' => 'required|numeric|min:0',
                'data.sale_price' => 'nullable|numeric|min:0',
                'data.priority' => 'nullable|numeric|min:0',
                'data.part_number' => 'nullable|in:' . EnumCoursePart::asStringValues(),
            ],
            [],
            [
                'data.title' => 'عنوان',
                'data.parent_id' => 'دسته بندی والد',
                'data.course_age' => 'رده سنی دوره',
                'data.course_type' => 'نوع دوره',
                'data.price' => 'قیمت اصلی دوره',
                'data.sale_price' => 'قیمت فروش دوره',
                'data.priority' => 'الویت',
            ]
        );
        $this->updateCourse();
        $this->alert('دوره با موفقیت ویرایش شد.')->success();
        return redirect()->to(route('admin.courses.index'));
    }

    protected function updateCourse()
    {
        $this->course->update([
            'title' => $this->data['title'],
            'part_number' => $this->data['part_number'],
            'parent_id' => $this->data['parent_id'],
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
        return view('livewire.admin.courses.live-course-edit', compact('courses', 'courseTypes', 'courseAges', 'courseParts'));
    }
}
