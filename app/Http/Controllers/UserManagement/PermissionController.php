<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PermissionRepositories;
use App\Repositories\RoleRepositories;

class PermissionController extends Controller
{
    private $permissionRepositories;

    public function __construct(PermissionRepositories $permissionRepositories,RoleRepositories $roleRepositories)
    {
        $this->permissionRepositories = $permissionRepositories;
        $this->roleRepositories = $roleRepositories;
        // $this->middleware(['permission:read permissions']);
        // $this->middleware(['permission:create permissions'])->only('create');
        // $this->middleware(['permission:update permissions'])->only('update');
        // $this->middleware(['permission:delete permissions'])->only('delete');
    }

    public function getAllPermissions ()
    {
        return $this->permissionRepositories->getAllPermissions();
    }

    public function create (Request $req)
    {
        return $this->permissionRepositories->create($req);
    }

    public function update (Request $req)
    {
        return $this->permissionRepositories->update($req);
    }

    public function delete (Request $req)
    {
        return $this->permissionRepositories->delete($req);
    }

    public function userWithRoleAndPermissios (Request $req)
    {
        return $this->roleRepositories->userWithRoleAndPermissios($req);
    }
}
