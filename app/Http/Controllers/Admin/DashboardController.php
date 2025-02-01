<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listeing;
use App\Models\User;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $users = User::count();
        $active_users = User::where('status', '1')->count();
        $inactive_users = $users - $active_users;
        $listeings = Listeing::count();
        return inertia('Admin/Dashboard/Dashboard', get_defined_vars());
    }
}
