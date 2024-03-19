<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\ResponseJsonService;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:permission {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new permission';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = $this->argument('name');

            DB::beginTransaction();

            Permission::create(['name' => $name]);
            $permissions = Permission::all();
            
            $role = Role::firstOrCreate(['name' => 'super-admin']);
            $role->syncPermissions($permissions);

            $users = User::role('super-admin')->get();
            foreach ($users as $user) {
                $user->givePermissionTo($name);
                $user->assignRole($role);
            }

            DB::commit();

            $this->info("Permission '{$name}' created successfully!");
        } catch (\Exception $e) {
            $this->info($e->getMessage());
        }
    }
}
