<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminPassword = 'admin123';
        $managerPassword = 'manager123';
        $staff1Password = 'staff123';
        $staff2Password = 'staff456';

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => Hash::make('password'),
        // ]);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@itc.gic',
            'password' => Hash::make($adminPassword),
        ]);
        $manager = User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@itc.gic',
            'password' => Hash::make($managerPassword),
        ]);
        $staff1 = User::factory()->create([
            'name' => 'Staff One',
            'email' => 'staff1@itc.gic',
            'password' => Hash::make($staff1Password),
        ]);
        $staff2 = User::factory()->create([
            'name' => 'Staff Two',
            'email' => 'staff2@itc.gic',
            'password' => Hash::make($staff2Password),
        ]);

        $adminRole = role::where('name', 'admin')->first();
        $managerRole = role::where('name', 'manager')->first();
        $staffRole = role::where('name', 'staff')->first();

        $admin->roles()->attach($adminRole);
        $manager->roles()->attach($managerRole);
        $staff1->roles()->attach($staffRole);
        $staff2->roles()->attach($staffRole);
    }
}
