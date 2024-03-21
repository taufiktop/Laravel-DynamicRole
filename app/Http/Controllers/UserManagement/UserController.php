<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepositories;

class UserController extends Controller
{
    private $userRepositories;

    public function __construct(UserRepositories $userRepositories)
    {
        $this->userRepositories = $userRepositories;
        $this->middleware(['permission:read users']);
        $this->middleware(['permission:create users'])->only('create');
        $this->middleware(['permission:update users'])->only('update');
        $this->middleware(['permission:delete users'])->only('delete');
    }

    public function index(Request $req)
    {
        return $this->userRepositories->getAllUser($req);
    }

    public function detail(Request $req)
    {
        return $this->userRepositories->getDetailUser($req);
    }

    public function create(Request $req)
    {
        return $this->userRepositories->addUser($req);
    }

    public function update(Request $req)
    {
        return $this->userRepositories->updateUser($req);
    }

    public function delete(Request $req)
    {
        return $this->userRepositories->deleteUser($req);
    }
}
