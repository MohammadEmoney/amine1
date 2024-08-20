<?php

namespace App\Livewire\Admin\Dashboards;

use App\Models\Semester;
use App\Models\User;
use Livewire\Component;

class LiveStudentSearch extends Component
{
    public $type;
    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;
    public $searchSemester;

    public function show($id)
    {
        return redirect()->to(route('admin.users.student.show', $id));
    }

    public function edit($id)
    {
        return redirect()->to(route('admin.users.student.edit', $id));
    }

    public function createStudent()
    {
        return redirect()->to(route('admin.users.student.create'));
    }

    public function createSemester()
    {
        return redirect()->to(route('admin.semesters.create'));
    }

    public function render()
    {
        $users = User::query()->with(['userInfo', 'orders'])->whereRelation('userInfo', 'type', 'student');
        $search = trim($this->search);
        if($search && mb_strlen($search) > 2){
            $users = $users->where(function($query) use ($search){
                $query->where('first_name', "like", "%$search%")
                    ->orWhere('last_name', "like", "%$search%")
                    ->orWhere('email', "like", "%$search%")
                    ->orWhere('national_code', "like", "%$search%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"])
                    ->orWhereHas('userInfo', function($query) use ($search){
                        $query->where('mobile_1', 'like', "%$search%")
                        ->orWhere('mobile_2', "like", "%$search%")
                        ->orWhere('landline_phone', "like", "%$search%");
                    });
            });
        }
        $users = $users->orderBy($this->sort, $this->sortDirection)->take(10)->get();

        // dd($users->first()->orders()->book()->first()->trans_status, $users->first()->orders, $users->first()->id);

        $semesters = Semester::query()->with(['students', 'course']);
        if($this->searchSemester && mb_strlen($this->searchSemester) > 2){
            $semesters = $semesters->whereRelation('course', 'title', 'like', "%$this->searchSemester%")
                            ->orWhereHas('teacher',function($query) {
                                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$this->searchSemester%"]);
                            });
        }
        $semesters = $semesters->orderBy($this->sort, $this->sortDirection)->take(10)->get();

        return view('livewire.admin.dashboards.live-student-search', compact('users', 'semesters'));
    }
}
