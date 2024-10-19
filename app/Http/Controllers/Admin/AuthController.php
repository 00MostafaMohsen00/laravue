<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login()
    {
        return inertia('Admin/Auth/Login');
    }
    public function loginSave(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth('admin')->attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', __('auth.success'));
        }
        return back()->withErrors([
            'email' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        auth('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', __('auth.logged_out_succes'));
    }
}
