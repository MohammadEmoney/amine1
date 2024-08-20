<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Traits\AlertLiveComponent;
use Livewire\Component;

class LiveCourseIndex extends Component
{
    use AlertLiveComponent;

    protected $listeners = ['destroy'];

    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;

    public function create()
    {
        return redirect()->to(route('admin.courses.create'));
    }

    public function edit($id)
    {
        return redirect()->to(route('admin.courses.edit', $id));
    }

    public function destroy($id)
    {
        if(auth()->user()->can('course_delete')){
            $course = Course::query()->find($id);

            if ($course) {
                $course->delete();
                $this->alert('دوره حذف شد')->success();
            }
            else{
                $this->alert('دوره حذف نشد')->error();
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
        $courses = Course::query();
        if($this->search && mb_strlen($this->search) > 2){
            $courses = $courses->where(function($query){
                $query->where('title', "like", "%$this->search%");
            });
        }
        $courses = $courses->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.admin.courses.live-course-index', compact('courses'));
    }
}
