<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register()
    {
        return inertia('Auth/Register');
    }

    public function registerSave(UserCreateRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        auth()->login($user);

        return redirect()->intended(route('listeing.index'))->with('success', __('lang.account_created'));
    }
}
