<?php

namespace App\Livewire\Admin\Auth;

use App\Enums\EnumUserRoles;
use App\Models\User;
use App\Traits\AlertLiveComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LiveLogin extends Component
{
    use AlertLiveComponent;

    public $email;
    public $password;
    public $remember_me;

    public function render()
    {
        return view('livewire.admin.auth.live-login');
    }

    public function login()
    {
        $this->validate(
            ['email' => 'required|email', 'password' => 'required', 'remember_me' => 'nullable|boolean'],
            [],
            ['email' => 'نام کاربری', 'password' => 'رمز عبور', 'remember_me' => 'مرا به خاطر بسپار']
        );

        try {
            $user = User::where('email' , $this->email)->first();
            if($user && $user->password && $user->hasRole(EnumUserRoles::getAdminRoles())){
                if(Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)){
                    $this->alert("با موفقیت وارد شدید.")->success();
                    return redirect()->to(route('admin.dashboard'));
                }
            }
            $this->alert('نام کاربری یا رمز عبور صحیح نمی باشد.')->error();
        } catch (\Exception $e) {
            $this->alert($e->getMessage())->error();
        }
    }
}
