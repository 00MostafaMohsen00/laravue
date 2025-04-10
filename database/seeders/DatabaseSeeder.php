<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test2@example.com',
        ]);
        \App\Models\Listeing::factory(10)->create([
            'user_id' => 1,
        ]);
        \App\Models\Listeing::factory(10)->create([
            'user_id' => 2,
        ]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
