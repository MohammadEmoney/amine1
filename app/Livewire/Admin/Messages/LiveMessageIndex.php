<?php

namespace App\Livewire\Admin\Messages;

use App\Models\Message;
use App\Traits\AlertLiveComponent;
use Livewire\Component;

class LiveMessageIndex extends Component
{
    use AlertLiveComponent;

    protected $listeners = ['destroy'];

    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;

    public function create($type)
    {
        return redirect()->to(route("admin.messages.$type.create"));
    }

    public function edit($id)
    {
        return redirect()->to(route('admin.messages.edit', $id));
    }

    public function destroy($id)
    {
        if(auth()->user()->can('message_delete')){
            $message = Message::query()->find($id);

            if ($message) {
                $message->delete();
                $this->alert('پیام حذف شد')->success();
            }
            else{
                $this->alert('پیام حذف نشد')->error();
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
        $messages = Message::query();
        if($this->search && mb_strlen($this->search) > 2){
            $messages = $messages->where(function($query){
                $query->where('title', "like", "%$this->search%");
            });
        }
        $messages = $messages->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.admin.messages.live-message-index', compact('messages'))->extends('layouts.admin-panel')->section('content');
    }
}
