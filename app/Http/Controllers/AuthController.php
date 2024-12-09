<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return inertia('Auth/Login');
    }
    public function loginSave(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials, true)) {
            if (auth()->user()->status == '0') {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => __('lang.account_inactive')]);
            }
            $request->session()->regenerate();
            return redirect()->intended(route('listeing.index'))->with('success', __('auth.success'));
        }
        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', __('auth.logged_out_succes'));
    }

    public function profile()
    {
        $user = auth()->user();
        return inertia('Auth/Profile', get_defined_vars());
    }

    public function profileSave(ProfileRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());
        return redirect()->route('profile')->with('success', __('lang.success'));
    }
}
