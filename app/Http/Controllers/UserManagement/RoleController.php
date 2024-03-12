<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RoleRepositories;

class RoleController extends Controller
{
    private $roleRepositories;

    public function __construct(RoleRepositories $roleRepositories)
    {
        $this->roleRepositories = $roleRepositories;
        $this->middleware(['permission:read roles']);
        $this->middleware(['permission:create roles'])->only('create');
        $this->middleware(['permission:update roles'])->only('update');
        $this->middleware(['permission:delete roles'])->only('delete');
    }

    public function index(Request $req)
    {
        return $this->roleRepositories->getRole($req);
    }

    public function detail(Request $req)
    {
        return $this->roleRepositories->getDetailRole($req);
    }

    public function create(Request $req)
    {
        return $this->roleRepositories->addRole($req);
    }

    public function update(Request $req)
    {
        return $this->roleRepositories->updateRole($req);
    }

    public function delete(Request $req)
    {
        return $this->roleRepositories->deleteRole($req);
    }
}
