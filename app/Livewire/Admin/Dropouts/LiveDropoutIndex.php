<?php

namespace App\Livewire\Admin\Dropouts;

use App\Models\Course;
use App\Models\User;
use App\Traits\AlertLiveComponent;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class LiveDropoutIndex extends Component
{
    use AlertLiveComponent, WithPagination, FilterTrait;

    protected $listeners = [ 'destroy'];

    public $type;
    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;

    public function create()
    {
        return redirect()->to(route('admin.users.waiting.create'));
    }

    public function edit($id)
    {
        return redirect()->to(route('admin.users.dropouts.edit', $id));
    }

    public function show($id)
    {
        return redirect()->to(route('admin.users.waiting.show', $id));
    }

    public function destroy($id)
    {
        if(auth()->user()->can('user_delete')){
            $user = User::query()->find($id);

            if ($user) {
                $user->delete();
                $this->alert('کاربر حذف شد')->success();
            }
            else{
                $this->alert('کاربر حذف نشد')->error();
            }
        }else{
            $this->alert('شما اجازه دسترسی به این بخش را ندارید.')->error();
        }
    }
    
    public function addToStudents($id)
    {
        if(auth()->user()->can('user_student_role')){
            $user = User::query()->find($id);

            if ($user) {
                $user->syncRoles('student');
                $this->alert('کاربر به لیست دانش آموزان اضافه شد')->success();
            }
            else{
                $this->alert('کاربر به لیست دانش آموزان اضافه نشد')->error();
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
        $courses = Course::orderBy('priority')->get();
        $users = User::query()->role('student')->whereHas('dropout')->with(['userInfo']);
        if($this->search && mb_strlen($this->search) > 2){
            $users = $users->where(function($query){
                $query->where('first_name', "like", "%$this->search%")
                    ->orWhere('last_name', "like", "%$this->search%")
                    ->orWhere('email', "like", "%$this->search%")
                    ->orWhere('national_code', "like", "%$this->search%")
                    ->orWhereHas('userInfo', function($query) {
                        $query->where('mobile_1', 'like', "%$this->search%")
                        ->orWhere('mobile_2', "like", "%$this->search%")
                        ->orWhere('landline_phone', "like", "%$this->search%");
                    });
            });
        }
        if($preferdCourse = data_get($this->filters, 'preferd_course')){
            $users = $users->whereRelation('userInfo', 'preferd_course', $preferdCourse);
        }
        if($dropout = data_get($this->filters, 'dropout')){
            $users = $users->whereRelation('dropout', 'has_returned', false);
        }
        if($isForeigner = data_get($this->filters, 'is_foreigner')){
            $users = $users->where('is_foreigner', $isForeigner);
        }
        if($hasPersonalImage = data_get($this->filters, 'has_personal_image')){
            $users = $users->whereDoesntHave('media', function (Builder $query) {
                $query->whereIn('collection_name', ['personal_image', 'national_card_image']);
            });
        }
        if($hasNationalCardImage = data_get($this->filters, 'has_national_card_image')){
            $users = $users->whereDoesntHave('media', function (Builder $query) {
                $query->whereIn('collection_name', ['national_card']);
            });
        }
        $users = $users->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.admin.dropouts.live-dropout-index', compact('users', 'courses'))
            ->extends('layouts.admin-panel')
            ->section('content');
    }
}
