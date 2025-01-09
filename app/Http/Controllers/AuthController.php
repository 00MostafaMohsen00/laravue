<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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
        $data = $request->validated();
        $data['email'] = auth()->user()->provider ? auth()->user()->email : $data['email'];
        $user = auth()->user();
        $user->update($request->validated());
        return redirect()->route('profile')->with('success', __('lang.success'));
    }

    public function socialLogin($provider)
    {
        if (!in_array($provider, ['facebook', 'google'])) {
            abort(404);
        }
        $url = Socialite::driver($provider)->redirect()->getTargetUrl();
        return inertia()->location($url);
    }

    public function socialLoginCallback(Request $request, $provider)
    {
        $providerUser = Socialite::driver($provider)->stateless()->user();
        $user = User::where('email', $providerUser->getEmail())->first();
        if (!$user) {
            $data = [
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'status' => '1',
                'provider' => $provider,
            ];
            $user = User::create($data);
        } else {
            if ($user->status == '0') {
                return redirect()->route('login')->withErrors(['email' => __('lang.account_inactive')]);
            }
        }
        auth()->login($user);
        return redirect()->intended(route('listeing.index'))->with('success', __('auth.success'));
    }
}
