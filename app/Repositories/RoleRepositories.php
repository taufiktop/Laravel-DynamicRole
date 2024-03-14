<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use App\Service\ResponseJsonService;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

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
        try {
            $req->validate([
                'name' => 'required',
                'permissionId' => 'required|array|min:1'
            ]);
    
            DB::beginTransaction();

            $role = Role::create(['name' => $req->name]);
            $permissions = Permission::whereIn('id', $req->permissionId)->get();
            $role->givePermissionTo($permissions);

            DB::commit();
    
            return $this->responseJsonService->success();
        // } catch (\Illuminate\Validation\ValidationException $th) {
        //     return $this->responseJsonService->failed($th->validator->errors());
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            return $this->responseJsonService->failed($e->getMessage());
        }
        
    }

    public function updateRole ($req)
    {
        try {
            $req->validate([
                'id' => 'required',
                'name' => 'required',
                'permissionId' => 'required|array|min:1'
            ]);

            DB::beginTransaction();
    
            $role = Role::findOrFail($req->id);
            $role->name = $req->name;
            $role->save();

            $permissions = Permission::whereIn('id', $req->permissionId)->get();
            $role->syncPermissions($permissions);

            DB::commit();
    
            return $this->responseJsonService->success();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function deleteRole ($req)
    {
        try {
            $req->validate([
                'id' => 'required'
            ]);

            DB::beginTransaction();
    
            $role = Role::findOrFail($req->id);
            $role->revokePermissionTo($role->permissions);
            $role->delete();

            DB::commit();

            return $this->responseJsonService->success();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            return $this->responseJsonService->failed($e->getMessage());
        }
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

    public function userWithRoleAndPermissios($req)
    {
        try {
            $req->validate([
                'id' => 'required'
            ]);

            $user = User::find($req->id);
            $user->load('permissions');

            if($user)
            {
                $data = [$user];
            }
            else
            {
                $data = [];
            }

            return $this->responseJsonService->success($data);
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }
}