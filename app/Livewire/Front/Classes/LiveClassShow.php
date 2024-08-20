<?php

namespace App\Livewire\Front\Classes;

use App\Models\Semester;
use App\Traits\AlertLiveComponent;
use App\Traits\CartTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveClassShow extends Component
{
    use CartTrait, AlertLiveComponent;
    
    public $semester;
    public $title;

    public function mount(Semester $semester)
    {
        $this->semester = $semester;
        $this->title = $semester->course?->title_with_part ?: "-"; 
    }

    public function addToCart()
    {
        if(Auth::check()){
            $this->addSemesterToCart($this->semester);
            $this->alert('به سبد خرید اضافه شد.')->success();
        }else{
            $this->alert('لطفا ابتدا وارد شوید.')->warning();
        }
    }

    public function render()
    {
        return view('livewire.front.classes.live-class-show')->extends('layouts.front')->section('content');
    }
}
