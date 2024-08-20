<?php

namespace App\Livewire\Admin\Dashboards;

use App\Models\Course;
use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class LiveDashboardStatusCard extends Component
{
    public $students;
    public $dropoutStudents;
    public $waitingStudents;
    public $staff;
    public $dropoutStaff;
    public $orders;
    public $courses;
    public $notActiveCourses;

    public function mount()
    {
        $courses= Course::query();

        $notActive = clone $courses;

        $users = User::query();
        $waitingStudents = clone $users;
        $dropoutUsers = clone $users;
        $staff = clone $users;
        $dropoutStaff = clone $users;

        $staff = $staff->whereDoesntHave('dropout')->with('roles')->get()->filter(
            fn ($user) => $user->roles->whereIn('name',['admin', 'supervisor', 'management', 'secretary', 'head-teacher', 'teacher', 'accountant'])->toArray()
        )->count();

        $dropoutStaff = $dropoutStaff->whereHas('dropout')->with('roles')->get()->filter(
            fn ($user) => $user->roles->whereIn('name',['admin', 'supervisor', 'management', 'secretary', 'head-teacher', 'teacher', 'accountant'])->toArray()
        )->count();

        $students = $users->role('student')->doesntHave('dropout')->count();
        $dropoutStudents = $dropoutUsers->role('student')->whereHas('dropout')->count();
        $waitingStudents = $waitingStudents->role('waiting-student')->count();


        $this->students = $students;
        $this->dropoutStudents = $dropoutStudents;
        $this->staff = $staff;
        $this->dropoutStaff = $dropoutStaff;
        $this->waitingStudents = $waitingStudents;
        $this->orders = 0;
        $this->courses = $courses->active()->count();
        $this->notActiveCourses = $courses->notActive()->count();
    }

    public function redirectTo($route)
    {
        return redirect()->to(route($route));
    }

    public function render()
    {
        return view('livewire.admin.dashboards.live-dashboard-status-card');
    }
}
