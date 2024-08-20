<?php

namespace App\Livewire\Admin\Users;

use App\Traits\AlertLiveComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class LiveUserPassword extends Component
{
    use AlertLiveComponent;

    public $disabledCreate = true;
    public $data = [];

    public function passwordValidation()
    {
        $this->validate([
            'data.current_password' => 'required',
            'data.password' => 'required|confirmed|min:8|max:255',
        ],[
        ],[
            'data.password' => 'رمز عبور',
            'data.current_password' => 'رمز عبور فعلی',
        ]);
    }

    public function updatedData()
    {
        $this->disabledCreate = true;
        $this->passwordValidation();
        $this->disabledCreate = false;
    }

    public function checkData()
    {
        $this->disabledCreate = true;
        $this->passwordValidation();
        $this->disabledCreate = false;
    }

    public function submit()
    {
        $this->passwordValidation();
        $user = Auth::user();
        if(Hash::check($this->data['current_password'], $user->password)){
            try {
                DB::beginTransaction();
                $user->update(['password' => Hash::make($this->data['password'])]);
                DB::commit();
                $this->data = [];
                $this->alert('رمز عبور با موفقیت تغییر یافت.')->success();
            } catch (\Exception $e) {
                $this->alert($e->getMessage())->error();
            }
           
        }else{
            $this->alert("رمز فعلی صحیح نمی باشد.")->error();
        }
    }

    public function render()
    {
        return view('livewire.admin.users.live-user-password')->extends('layouts.admin-panel')->section('content');
    }
}
