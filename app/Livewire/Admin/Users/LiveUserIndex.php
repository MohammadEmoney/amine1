<?php

namespace App\Livewire\Admin\Users;

use App\Enums\EnumUserType;
use App\Models\Course;
use App\Models\User;
use App\Traits\AlertLiveComponent;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class LiveUserIndex extends Component
{
    use AlertLiveComponent, WithPagination, FilterTrait;

    protected $listeners = [ 'destroy'];

    public $type;
    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;

    public function mount( )
    {
        // $this->filters = [
        //     // 'name' => '',
        //     // Add more filters as needed
        // ];
    }


    public function show($id)
    {
        return redirect()->to(route('admin.users.' . $this->type .'.show', $id));
    }

    public function create($type)
    {
        return redirect()->to(route('admin.users.' . $this->type .'.create'));
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

    public function edit($id)
    {
        return redirect()->to(route('admin.users.'. $this->type .'.edit', $id));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $courses = Course::orderBy('priority')->get();
        $users = User::query()->with(['userInfo', 'dropout'])->whereRelation('userInfo', 'type', $this->type);
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
        // $users = $users ->when($this->filters['name'], function ($query) {
        //     return $this->filterByName($query, $this->filters['name']);
        // });
           
        $users = $users->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);

        return view('livewire.admin.users.live-user-index', compact('users', 'courses'));
    }
}
