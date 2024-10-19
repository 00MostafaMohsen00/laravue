<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'admin',
        ]);

        $ids = Permission::pluck('id')->toArray();

        $role->syncPermissions($ids);
    }
}
