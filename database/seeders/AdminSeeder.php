<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::updateOrCreate([
            'name' => 'Laravue',
            'email' => 'laravue@laravue.com',
            'password' => 'Laravue!@#123',
        ]);

        $admin->assignRole('superadmin');
    }
}
