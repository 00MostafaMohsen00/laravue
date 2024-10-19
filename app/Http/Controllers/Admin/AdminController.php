<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\CreateRequest;
use App\Http\Requests\Admin\Admin\UpdateRequest;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public $roles;
    public function __construct()
    {
        $this->roles = Role::where('id', '!=', 1)->get();
    }
    public function index()
    {
        $admins = Admin::where('id', '!=', 1)->with('roles')->paginate(10);
        return inertia('Admin/Admins/Index', get_defined_vars());
    }


    public function create()
    {
        $roles = $this->roles;

        return inertia('Admin/Admins/Create', get_defined_vars());
    }


    public function store(CreateRequest $request)
    {

        $admin = Admin::create($request->validated());
        $role = Role::find($request->role_id);
        $admin->assignRole($role->name);

        return redirect()->route('admins.index')->with('success', __('lang.success'));
    }


    public function edit(string $id)
    {
        if ($id == 1) return redirect()->route('admins.index');

        $admin = Admin::findOrFail($id);
        $role_id = $admin->roles[0]->id;
        $roles = $this->roles;
        return inertia('Admin/Admins/Edit', get_defined_vars());
    }


    public function update(UpdateRequest $request, string $id)
    {
        if ($id == 1) return redirect()->route('admins.index');
        $admin = Admin::findOrFail($id);
        $admin->update($request->validated());
        $role = Role::find($request->role_id);
        $admin->syncRoles($role->name);

        return redirect()->route('admins.index')->with('success', __('lang.success'));
    }


    public function destroy(string $id)
    {

        if ($id == 1) return redirect()->route('admins.index');

        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admins.index')->with('success', __('lang.success'));
    }
}
