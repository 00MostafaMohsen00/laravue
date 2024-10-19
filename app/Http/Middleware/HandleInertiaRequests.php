<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use LaravelLocalization;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization as FacadesLaravelLocalization;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        if (auth()->guard('admin')->check()) {
            $user = auth()->guard('admin')->user();
            $user_role =  auth()->guard('admin')->user()->roles[0]->name;
            $user_permissions = auth()->guard('admin')->user()->roles[0]->permissions->pluck('name')->toArray();
        } else {
            $user = auth()->user();
        }
        return array_merge(parent::share($request), [
            'flash' => [
                'success' => $request->session()->get('success'),
            ],
            'user' => $user ?? null,
            'user_role' => $user_role ?? null,
            'user_permissions' => $user_permissions ?? null,
            'notifications_count' => auth('web')->user() ? auth('web')->user()->unreadNotifications()->count() : null,
            'languages' => LaravelLocalization::getSupportedLocales(),
            'local_name' => FacadesLaravelLocalization::getCurrentLocaleNative(),
            'local_code' => FacadesLaravelLocalization::getCurrentLocale(),
            "local_dir" => FacadesLaravelLocalization::getCurrentLocaleDirection(),
        ]);
    }
}
