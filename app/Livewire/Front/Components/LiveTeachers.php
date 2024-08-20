<?php

namespace App\Livewire\Front\Components;

use App\Enums\EnumUserType;
use App\Models\User;
use Livewire\Component;

class LiveTeachers extends Component
{
    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;
    public $searchTerm;
    public $showAll = false;
    public $disableSearchBtn = true;
    public $display;
    public $title;
    
    public function render()
    {
        $users = User::query()->role('teacher')->with(['userInfo'])->whereRelation('userInfo', 'type', EnumUserType::STAFF);
        $users = $users->orderBy($this->sort, $this->sortDirection)->take(4)->get();
        return view('livewire.front.components.live-teachers', compact('users'));
    }
}
