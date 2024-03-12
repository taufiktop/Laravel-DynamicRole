<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use App\Service\ResponseJsonService;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class RoleRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function getRole ($req)
    {
        $req->validate([
            'page' => 'required|integer'
        ]);
        $data = Role::paginate(10, ['*'], 'page', $req->page);
        return $this->responseJsonService->success($data);
    }

    public function getDetailRole ($req)
    {
        $req->validate([
            'roleId' => 'required'
        ]);

        $role = Role::with('permissions')->find($req->roleId);;
        if($role)
        {
            $data = [$role->load('permissions')];
        }
        else
        {
            $data = [];
        }

        return $this->responseJsonService->success($data);
    }

    public function addRole ($req)
    {
        $req->validate([
            'name' => 'required',
            'permissionId' => 'required|array|min:1'
        ]);

        Role::create(['name' => $req->name]);
        $permissions = Permission::whereIn('id', $req->permissionId)->get();
        $role->syncPermissions($permissions);

        return $this->responseJsonService->success();
    }

    public function updateRole ($req)
    {
        $req->validate([
            'id' => 'required',
            'name' => 'required',
            'permissionId' => 'required|array|min:1'
        ]);

        Role::where('id',$req->id)->update(['name' => $req->name]);
        $permissions = Permission::whereIn('id', $req->permissionId)->get();
        $role->syncPermissions($permissions);

        return $this->responseJsonService->success();
    }

    public function deleteRole ($req)
    {
        $req->validate([
            'id' => 'required'
        ]);

        $data = Role::where('id',$req->id)->delete();
        return $this->responseJsonService->success();
    }

    public function checkHasPermissions()
    {
        if (Gate::allows('read roles')) {
            // User has permission to read carts
            return 'You have permission to read roles';
        } else {
            // User does not have permission
            return 'You do not have permission to read roles';
        }
    }

    public function userWithRoleAndPermissios()
    {
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $superAdmin = User::where('name', 'Super Admin')->first();
        $superAdmin->assignRole($superAdminRole);

        $user = User::find(1);
        $user->load('permissions');

        return $user;
    }
}