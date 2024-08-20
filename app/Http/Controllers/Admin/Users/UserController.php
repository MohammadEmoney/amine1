<?php

namespace App\Http\Controllers\Admin\Users;

use App\Enums\EnumUserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->segments()[2] ?? null;
        return view('admin.users.index', compact('type'));
    }

    public function create(Request $request)
    {
        $type = $request->segments()[2] ?? null;
        return view('admin.users.create', compact('type'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
}
