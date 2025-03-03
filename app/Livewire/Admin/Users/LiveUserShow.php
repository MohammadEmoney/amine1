<?php

namespace App\Livewire\Admin\Users;

use App\Notifications\Users\BookNotification;
use App\Notifications\Users\LessonPlanNotification;
use App\Notifications\Users\ReportCardNotification;
use App\Notifications\Users\TuitionNotification;
use App\Traits\AlertLiveComponent;
use App\Traits\ModalLiveComponent;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class LiveUserShow extends Component
{
    use AlertLiveComponent;
    use ModalLiveComponent;

    public $user;
    public $permissions;
    public $tuitions;
    public $books;
    public $data = [];
    public $allFalsePermissions = [];
    public $allTruePermissions = [];
    public $allAssignedPermissions = [];

    public function mount()
    {
        $this->user = $this->user->load(['media', 'userInfo', 'jobReferences', 'roles', 'orders']);

        $orders = $this->user->orders;
        $this->tuitions = $orders->where('type', 'tuition');
        $this->books = $orders->where('type', 'book');

        $this->permissions = $permissions = Permission::all();
        $this->allFalsePermissions = $permissions->pluck('id', 'id')->map(function ($item) {
            return false;
        })->toArray();
        $rolePermissions = $this->user->permissions()->pluck('id', 'id')->map(function ($item) {
            return true;
        })->toArray();
        $this->allTruePermissions = $permissions->pluck('id', 'id')->map(function ($item) {
            return true;
        })->toArray();
        $this->allAssignedPermissions = $permissions->pluck('id', 'id')->map(function ($item) {
            return true;
        })->toArray();
        $meregedArray = $rolePermissions + $this->allFalsePermissions;
        $this->data['direct_permissions'] = $meregedArray;

    }

    public function edit()
    {
        $type = $this->user->type ?: 'student';
        return redirect()->to(route("admin.users.$type.edit", $this->user->id));
    }

    public function reportCard()
    {
        $this->alert('این بخش در دست ساخت می باشد!')->error();
        // $type = $this->user->type ?: 'student';
        // return redirect()->to(route("admin.users.$type.edit", $this->user->id));
    }

    public function courses()
    {
        $this->alert('این بخش در دست ساخت می باشد!')->error();
        // $type = $this->user->type ?: 'student';
        // return redirect()->to(route("admin.users.$type.edit", $this->user->id));
    }

    public function finances()
    {
        $this->alert('این بخش در دست ساخت می باشد!')->error();
        // $type = $this->user->type ?: 'student';
        // return redirect()->to(route("admin.users.$type.edit", $this->user->id));
    }

    public function send($type)
    {
        switch ($type) {
            case 'tuition':
                $this->user->notify(new TuitionNotification());
                break;
            case 'book':
                $this->user->notify(new BookNotification());
                break;
            case 'lessonPlan':
                $this->user->notify(new LessonPlanNotification());
                break;
            case 'reportCard':
                $this->user->notify(new ReportCardNotification());
                break;
            
            default:
                $this->alert('اطلاعات مورد نظر پیدا نشد');
                break;
        }
    }

    protected function sendTuition()
    {
        // 
    }

    public function render()
    {
        return view('livewire.admin.users.live-user-show');
    }
}
