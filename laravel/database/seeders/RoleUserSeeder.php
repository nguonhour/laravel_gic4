<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\role;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'admin@itc.gic' => 'admin',
            'manager@itc.gic' => 'manager',
            'staff1@itc.gic' => 'staff',
            'staff2@itc.gic' => 'staff',
        ];

        foreach ($map as $email => $roleName) {
            $user = User::where('email', $email)->first();
            $r = role::where('name', $roleName)->first();
            if (! $user) {
                echo "User missing: {$email}\n";
                continue;
            }
            if (! $r) {
                echo "Role missing: {$roleName}\n";
                continue;
            }
            if (! $user->roles()->where('role_id', $r->id)->exists()) {
                $user->roles()->attach($r->id);
                echo "attached {$email} => {$roleName}\n";
            } else {
                echo "exists {$email} => {$roleName}\n";
            }
        }
    }
}
