<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'phone_number' => '08123456789',
            'role' => 'super-admin',
            'password' => Hash::make('Password1!'),
            'created_at' => now()
        ]);

        // Get all permissions
        $permissions = Permission::all();

        // Give all permissions to the user
        $superAdmin->syncPermissions($permissions);

        // Create the super-admin role if it doesn't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->assignRole($superAdminRole);

        DB::table('role_user')->insert([
            'user_uuid' => $superAdmin->uuid,
            'role_uuid' => $superAdminRole->uuid
        ]);
    }
}