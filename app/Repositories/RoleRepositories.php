<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use App\Service\ResponseJsonService;
use Spatie\Permission\Models\Role;

class RoleRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function getRole ($req)
    {
        $data = Role::paginate(10, ['*'], 'page', $req->page);
        return $this->responseJsonService->success($data);
    }

    public function addRole ($req)
    {
        $req->validate([
            'name' => 'required'
        ]);

        Role::create(['name' => $req->name]);
        return $this->responseJsonService->success();
    }

    public function updateRole ($req)
    {
        $req->validate([
            'id' => 'required',
            'name' => 'required'
        ]);

        Role::where('id',$req->id)->update(['name' => $req->name]);
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
}