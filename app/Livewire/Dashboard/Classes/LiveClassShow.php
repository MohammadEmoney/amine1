<?php

namespace App\Livewire\Dashboard\Classes;

use App\Models\Semester;
use App\Traits\AlertLiveComponent;
use App\Traits\CartTrait;
use Livewire\Component;

class LiveClassShow extends Component
{
    use CartTrait, AlertLiveComponent;

    public $semester;

    public function mount(Semester $semester)
    {
        $this->semester = $semester;    
    }

    public function sub()
    {
        // 
    }

    public function manageStudents()
    {
        return redirect()->to(route(''));
    }

    public function addToCart()
    {
        // if(count($this->carts)){
            // $this->alert('شما یک سفارش تکمیل نشده دارید.')->warning()->redirect('profile.checkout.index');
        // }else{
            $this->addSemesterToCart($this->semester);
            $this->alert('به سبد خرید اضافه شد.')->success()->redirect('profile.checkout.index');
        // }
    }

    public function render()
    {
        return view('livewire.dashboard.classes.live-class-show')
            ->extends('layouts.panel')->section('content');
    }
}
