<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\role;
use App\Models\permissions;
use App\Models\permission_role;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $AdminId = DB::table('roles')->insertGetId(['name' => 'admin']);
        $ManagerId = DB::table('roles')->insertGetId(['name' => 'manager']);
        $StaffId = DB::table('roles')->insertGetId(['name' => 'staff']);

        $permissions = [
            'products.view',
            'products.edit',
            'products.create',
            'products.delete',
            'categories.view',
            'categories.edit',
            'categories.create',
            'categories.delete',
        ];

        $permissionIds = [];
        foreach ($permissions as $permissionName) {
            $permissionIds[$permissionName] = DB::table('permissions')->insertGetId(['name' => $permissionName]);
        } 

        DB::table('permission_roles')->insert([
            // ADMIN PERMISSIONS
            ['permission_id' => $permissionIds['products.view'], 'role_id' => $AdminId],
            ['permission_id' => $permissionIds['products.edit'], 'role_id' => $AdminId],
            ['permission_id' => $permissionIds['products.create'], 'role_id' => $AdminId],
            ['permission_id' => $permissionIds['products.delete'], 'role_id' => $AdminId],
            
            ['permission_id' => $permissionIds['categories.view'], 'role_id' => $AdminId],
            ['permission_id' => $permissionIds['categories.edit'], 'role_id' => $AdminId],
            ['permission_id' => $permissionIds['categories.create'], 'role_id' => $AdminId],
            ['permission_id' => $permissionIds['categories.delete'], 'role_id' => $AdminId],

            // MANAGER PERMISSIONS
            ['permission_id' => $permissionIds['products.view'], 'role_id' => $ManagerId],
            ['permission_id' => $permissionIds['products.edit'], 'role_id' => $ManagerId],
            ['permission_id' => $permissionIds['products.create'], 'role_id' => $ManagerId],

            ['permission_id' => $permissionIds['categories.view'], 'role_id' => $ManagerId],
            ['permission_id' => $permissionIds['categories.edit'], 'role_id' => $ManagerId],
            ['permission_id' => $permissionIds['categories.create'], 'role_id' => $ManagerId],


            // STAFF PERMISSIONS
            ['permission_id' => $permissionIds['products.view'], 'role_id' => $StaffId],
            ['permission_id' => $permissionIds['categories.view'], 'role_id' => $StaffId],
        ]);

    }
}
