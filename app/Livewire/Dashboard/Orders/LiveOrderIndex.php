<?php

namespace App\Livewire\Dashboard\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class LiveOrderIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';

    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;
    public $filter = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = Order::query()->where('user_id', Auth::id())->with(['user', 'orderable']);
        $search = trim($this->search);
        if($search && mb_strlen($search) > 2){
            $orders = $orders->where(function($query) use ($search){
                $query->where('contract_number', "like", "%$search%");
            })->orWhereHas('user', function($query) use ($search){
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        }
        $orders = $orders->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.dashboard.orders.live-order-index', compact('orders'))
            ->extends('layouts.panel')->section('content');
    }
}
