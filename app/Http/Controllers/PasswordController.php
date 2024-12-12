<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ConfirmCode;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendOtp;
use App\Models\Otp;
use Exception;

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

    public function forgetPassword()
    {
        return inertia('Auth/ForgetPassword');
    }

    public function forgetPasswordSave(ForgetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->status == '0') {
            return redirect()->back()->withErrors(['email' => __('lang.account_inactive')]);
        }
        $otp = rand(1000, 9999);
        $token = Str::random(60);
        $user->otps()->create([
            'token' => $token,
            'otp' => $otp,
            'expired_at' => now()->addMinutes(5),
        ]);



        try {
            Mail::to($user->email)->send(new SendOtp($otp));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->route('otp')->with('success', __('lang.otp_sent'));
    }

    public function confirmCode()
    {
        return inertia('Auth/ConfirmCode');
    }

    public function confirmCodeSave(ConfirmCode $request)
    {
        $otp = $request->otp;
        $otpRecord = Otp::where('otp', $otp)
            ->where('expired_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return redirect()->back()->withErrors(['otp' => __('lang.invalid_otp')]);
        }

        $user = $otpRecord->user;
        auth()->login($user);

        return inertia('Auth/ResetPassword', [
            'token' => $otpRecord->token
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $otp = auth()->user()->otps()->where('token', $request['token'])
            ->first();

        if (!$otp) {
            return redirect()->back()->withErrors(['token' => __('lang.invalid_otp')]);
        }

        $otp->delete();
        auth()->user()->update([
            'password' => $request->new_password
        ]);
        return redirect()->route('profile')->with('success', __('lang.success'));
    }
}
