<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepositories;

class ProductController extends Controller
{
    private $productRepositories;

    public function __construct(ProductRepositories $productRepositories)
    {
        $this->productRepositories = $productRepositories;
    }

    public function index()
    {
        $this->middleware(['role:client']);
        return $this->productRepositories->getAllData();
    }

    public function getListByAdmin()
    {
        $this->middleware(['permission:read product']);
        return $this->productRepositories->getDataByAdmin();
    }

    public function create(Request $req)
    {
        $this->middleware(['permission:create product']);
        return $this->productRepositories->addData($req);
    }

    public function edit(Request $req)
    {
        $this->middleware(['permission:update product']);
        return $this->productRepositories->updateData($req);
    }

    public function delete(Request $req)
    {
        $this->middleware(['permission:delete product']);
        return $this->productRepositories->deleteData($req);  
    }
}
