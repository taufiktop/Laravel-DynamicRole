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
    }

    public function index ()
    {
        $this->middleware(['permission:read cart']);
        return $this->cartRepositories->getDataByClient();
    }

    public function create(Request $req)
    {
        $this->middleware(['permission:create cart']);
        return $this->cartRepositories->addData($req);
    }


    public function edit (Request $req) 
    {
        $this->middleware(['permission:update cart']);
        return $this->cartRepositories->updateData($req);
    }


    public function delete(Request $req)
    {
        $this->middleware(['permission:delete cart']);
        return $this->cartRepositories->deleteData($req);
    }
}
