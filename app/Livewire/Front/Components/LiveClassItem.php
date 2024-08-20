<?php

namespace App\Livewire\Front\Components;

use Livewire\Component;

class LiveClassItem extends Component
{
    public $semester;
    
    public function render()
    {
        return view('livewire.front.components.live-class-item');
    }
}
