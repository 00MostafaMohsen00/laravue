<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view users')->only(['index']);
        $this->middleware('permission:create users')->only(['create', 'store']);
        $this->middleware('permission:edit users')->only(['edit', 'update']);
        $this->middleware('permission:delete users')->only(['destroy']);
    }
    public function index()
    {
        $filters = ['search' => request()->search];
        $users = User::when(request('search'), function ($q) {
            $q->where('name', 'like', '%' . request('search') . '%')->orWhere('email', 'like', '%' . request('search') . '%');
        })
            ->paginate(10);
        // if (request()->isAjax) {
        //     return response()->json([
        //         'status' => true,
        //         'data' => $users
        //     ], 200);
        // }
        return inertia('Admin/Users/Index', get_defined_vars());
    }
}
