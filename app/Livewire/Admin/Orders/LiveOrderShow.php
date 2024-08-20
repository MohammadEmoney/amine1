<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;

class LiveOrderShow extends Component
{
    public $orderTitle;
    public $order;
    public $user;
    public $tempInstallments = [];

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->orderTitle = $order->type === "tuition" ? "شهریه" : "کتاب";
        $this->user = $order->user;
        $this->tempInstallments = $order->installments?->toArray();
        // dd($this->tempInstallments);
    }

    public function editOrder()
    {
        return redirect()->to(route('admin.orders.edit', $this->order->id));
    }

    public function render()
    {
        return view('livewire.admin.orders.live-order-show')
            ->extends('layouts.admin-panel')
            ->section('content');
    }
}
