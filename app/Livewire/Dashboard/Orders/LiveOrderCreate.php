<?php

namespace App\Livewire\Dashboard\Orders;

use Illuminate\Support\Facades\Config;
use Livewire\Component;

class LiveOrderCreate extends Component
{
    public $title;

    public function mount()
    {
        $this->title = "سفارش";
        Config::set('app.name', $this->title);
    }

    public function render()
    {
        return view('livewire.dashboard.orders.live-order-create')
            ->extends('layouts.panel')->section('content');
    }
}
