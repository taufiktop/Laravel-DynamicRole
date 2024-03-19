<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use App\Service\ResponseJsonService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PermissionRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function getAllPermissions()
    {
        try {
            $data = Permission::all();
            return $this->responseJsonService->success($data);
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function create ($req)
    {
        try {
            $req->validate([
                'name' => 'required'
            ]);

            DB::beginTransaction();

            Permission::create(['name' => $req->name]);
            $permissions = Permission::all();
            
            $role = Role::firstOrCreate(['name' => 'super-admin']);
            $role->syncPermissions($permissions);

            $users = User::role('super-admin')->get();
            foreach ($users as $user) {
                $user->givePermissionTo($req->name);
                $user->assignRole($role);
            }

            DB::commit();

            return $this->responseJsonService->success();
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function update ($req)
    {
        try {
            $req->validate([
                'uuid'    => 'required',
                'name'  => 'required'
            ]);

            DB::beginTransaction();
            Permission::where('uuid',$req->uuid)->update(['name' => $req->name]);
            DB::commit();

            return $this->responseJsonService->success();
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function delete ($req)
    {
        try {
            $req->validate([
                'uuid'    => 'required'
            ]);

            DB::beginTransaction();

            $permission = Permission::findOrFail($req->uuid);
            // Remove the permission from all roles
            $roles = Role::all();
            foreach ($roles as $role) {
                $role->revokePermissionTo($permission);
            }
            // Delete the permission
            $permission->delete();

            DB::commit();

            return $this->responseJsonService->success();
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }
}