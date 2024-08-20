<?php

namespace App\Livewire\Dashboard\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class LiveOrderShow extends Component
{
    public $order;
    public $title;

    public function mount(Order $order)
    {
        $this->order = $order;    
        $this->title = "سفارش";
        Config::set('app.name', $this->title);
    }

    public function render()
    {
        return view('livewire.dashboard.orders.live-order-show')
            ->extends('layouts.panel')->section('content');
    }
}
