<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Array of permission names
        $permissions = [
            'create roles',
            'read roles',
            'update roles',
            'delete roles',

            'create users',
            'read users',
            'update users',
            'delete users',

            'create products',
            'read products',
            'update products',
            'delete products',

            'create carts',
            'read carts',
            'update carts',
            'delete carts',

            'create orders',
            'read orders',
            'update orders',
            'delete orders',
        ];

        // Loop through the array and create each permission
        foreach ($permissions as $permissionName) {
            Permission::updateOrCreate([
                'name' => $permissionName,
                // 'uuid'   => (string)Str::uuid(),
            ]);
        }

        // Set super admin permissions
        $role = Role::updateOrCreate([
                'name' => 'super-admin',
                // 'uuid'   => (string)Str::uuid(),
        ])
            ->givePermissionTo(Permission::all());
    }
}