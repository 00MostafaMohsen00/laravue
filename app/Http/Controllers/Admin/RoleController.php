<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\RoleRequest;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public $pages = [];
    public $permissions = [];
    public function __construct()
    {

        $this->pages = [
            'users',
            'Listeings',
        ];

        $this->permissions = [
            'view',
            'create',
            'update',
            'delete',
        ];
    }
    public function index()
    {
        $roles = Role::where('id', '!=', 1)->paginate(10);

        return inertia('Admin/Roles/Index', get_defined_vars());
    }


    public function create()
    {
        $pages = $this->pages;
        $permissions = $this->permissions;

        return inertia('Admin/Roles/Create', get_defined_vars());
    }


    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', __('lang.success'));
    }


    public function edit(string $id)
    {
        if ($id == 1) return redirect()->route('admin.roles.index');
        $pages = $this->pages;
        $permissions = $this->permissions;
        $role = Role::findOrFail($id);
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return inertia('Admin/Roles/Edit', get_defined_vars());
    }


    public function update(RoleRequest $request, string $id)
    {
        if ($id == 1) return redirect()->route('admin.roles.index');

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', __('lang.success'));
    }


    public function destroy(string $id)
    {
        if ($id == 1) return redirect()->route('admin.roles.index');
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', __('lang.success'));
    }
}
