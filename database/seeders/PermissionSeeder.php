<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            'view users',
            'create users',
            'update users',
            'delete users',
            'view listeings',
            'create listeings',
            'update listeings',
            'delete listeings',
        ];
        foreach ($permission as $permission) {
            \Spatie\Permission\Models\Permission::updateOrcreate(['name' => $permission, 'guard_name' => 'admin']);
        }
    }
}
