<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Service\ResponseJsonService;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UserRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function getAllUser()
    {
        try {
            $data = User::all();
            
            return $this->responseJsonService->success($data);
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
        
    }

    public function getDetailUser($req)
    {
        try {
            $req->validate([
                'uuid' => 'required'
            ]);

            $user = User::find($req->uuid);

            if($user)
            {
                $user->load('permissions');
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

    public function addUser($req)
    {
        try {
            $req->validate([
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'role' => 'required',
                'password' => 'required',
            ]);

            DB::beginTransaction();

            $newUser = User::create([
                'name' => $req->name,
                'email' => $req->email,
                'phone_number' => $req->phone_number,
                'role' => $req->role,
                'password' => Hash::make($req->password),
                'created_at' => now()
            ]);
    
            // Get all permissions by role
            $role = Role::where('name', $req->role)->first();
            if(!$role)
            {
                return $this->responseJsonService->failed("role name doesn't exist");
            }
            $permissions = $role->permissions->pluck('uuid')->toArray();
    
            // Give all permissions to the user
            $newUser->syncPermissions($permissions);
            $newUser->assignRole($role);
    
            DB::table('role_user')->insert([
                'user_uuid' => $newUser->uuid,
                'role_uuid' => $role->uuid
            ]);

            DB::commit();

            return $this->responseJsonService->success();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseJsonService->failed($e->getMessage());
        }

    }

    public function updateUser($req)
    {
        try {
            $req->validate([
                'uuid' => 'required',
            ]);

        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }

    }

    public function deleteUser($req)
    {
        try {
            $req->validate([
                'uuid' => 'required'
            ]);

            //code

            if($data>0){
                return $this->responseJsonService->success();
            }
            else{
                return $this->responseJsonService->failed('Id not found');
            }

        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }
}