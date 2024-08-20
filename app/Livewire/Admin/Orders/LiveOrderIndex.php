<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\EnumPaymentMethods;
use App\Models\Order;
use App\Traits\AlertLiveComponent;
use Livewire\Component;

class LiveOrderIndex extends Component
{
    use AlertLiveComponent;

    protected $listeners = ['destroy'];

    public $paginate = 10;
    public $sort = 'created_at';
    public $sortDirection = 'DESC';
    public $search;
    public $filter = [];

    public function create()
    {
        return redirect()->to(route('admin.orders.create'));
    }

    public function edit($id)
    {
        return redirect()->to(route('admin.orders.edit', $id));
    }

    public function show($id)
    {
        return redirect()->to(route('admin.orders.show', $id));
    }

    public function destroy($id)
    {
        if(auth()->user()->can('order_delete')){
            $order = Order::query()->find($id);

            if ($order) {
                $order->delete();
                $this->alert('سفارش حذف شد')->success();
            }
            else{
                $this->alert('سفارش حذف نشد')->error();
            }
        }else{
            $this->alert('شما اجازه دسترسی به این بخش را ندارید.')->error();
        }
    }

    public function resetFilter()
    {
        $this->filter = [];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $paymentMethods = EnumPaymentMethods::getTranslatedAll();
        $orders = Order::query()->with(['user', 'orderable']);
        $search = trim($this->search);
        if($search && mb_strlen($search) > 2){
            $orders = $orders->where(function($query) use ($search){
                $query->where('contract_number', "like", "%$search%");
            })->orWhereHas('user', function($query) use ($search){
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        }
        if($orderType = data_get($this->filter, 'order_type')){
            $orders = $orders->where(function($query) use($orderType){
                $query->where('type', $orderType);
            });
        }
        if($paymentType = data_get($this->filter, 'payment_type')){
            $orders = $orders->where(function($query) use($paymentType){
                $query->where('payment_type', $paymentType);
            });
        }
        if($paymentMethod = data_get($this->filter, 'payment_method')){
            $orders = $orders->where(function($query) use($paymentMethod){
                $query->where('payment_method', $paymentMethod);
            });
        }
        if($paymentStatus = data_get($this->filter, 'payment_status')){
            $orders = $orders->where(function($query) use($paymentStatus){
                $query->where('payment_status', $paymentStatus);
            });
        }
        $orders = $orders->orderBy($this->sort, $this->sortDirection)->paginate($this->paginate);
        return view('livewire.admin.orders.live-order-index', compact('orders', 'paymentMethods'))->extends('layouts.admin-panel')->section('content');
    }
}
