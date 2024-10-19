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
        $listeings = Listeing::count();
        return inertia('Admin/Dashboard/Dashboard', get_defined_vars());
    }
}
