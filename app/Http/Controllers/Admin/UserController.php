<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view users')->only(['index']);
        $this->middleware('permission:create users')->only(['create', 'store']);
        $this->middleware('permission:update users')->only(['edit', 'update']);
        $this->middleware('permission:delete users')->only(['destroy']);
    }
    public function index()
    {
        $filters = ['search' => request()->search];
        $users = User::when(request('search'), function ($q) {
            $q->where('name', 'like', '%' . request('search') . '%')->orWhere('email', 'like', '%' . request('search') . '%');
        })
            ->paginate(10);
        return inertia('Admin/Users/Index', get_defined_vars());
    }

    public function create()
    {
        return inertia('Admin/Users/Create', get_defined_vars());
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->validated());
        return redirect()->route('users.index')->with('success', __('lang.success'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return inertia('Admin/Users/Edit', get_defined_vars());
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());
        return redirect()->route('users.index')->with('success', __('lang.success'));
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == '1' ? '0' : '1';
        $user->save();
        return redirect()->route('users.index')->with('success', __('lang.success'));
    }
}
