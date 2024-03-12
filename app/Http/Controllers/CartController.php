<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CartRepositories;

class CartController extends Controller
{
    private $cartRepositories;

    public function __construct(CartRepositories $cartRepositories)
    {
        $this->cartRepositories = $cartRepositories;
        $this->middleware(['role:client']);
        $this->middleware(['permission:read carts']);
        $this->middleware(['permission:create carts'])->only('create');
        $this->middleware(['permission:update carts'])->only('edit');
        $this->middleware(['permission:delete carts'])->only('delete');
    }

    public function index ()
    {
        return $this->cartRepositories->getDataByClient();
    }

    public function create(Request $req)
    {
        return $this->cartRepositories->addData($req);
    }


    public function edit (Request $req) 
    {
        return $this->cartRepositories->updateData($req);
    }


    public function delete(Request $req)
    {
        return $this->cartRepositories->deleteData($req);
    }
}
