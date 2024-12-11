<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Hash;

class PasswordController extends Controller
{
    public function changePassword()
    {
        return inertia('Auth/ChangePassword');
    }

    public function changePasswordSave(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => __('auth.password')]);
        }
        $user->update(['password' => $request->new_password]);

        return redirect()->route('profile')->with('success', __('lang.success'));
    }
}
