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
        // $this->middleware(['role:client'])->only('index');
        // $this->middleware(['permission:read products'])->except('index');
        // $this->middleware(['permission:create products'])->only('create');
        // $this->middleware(['permission:update products'])->only('edit');
        // $this->middleware(['permission:delete products'])->only('delete');
    }

    public function getMenu()
    {
        return $this->productRepositories->getMenu();
    }

    public function index()
    {
        return $this->productRepositories->getAllData();
    }

    public function getListByAdmin()
    {
        return $this->productRepositories->getDataByAdmin();
    }

    public function create(Request $req)
    {
        return $this->productRepositories->addData($req);
    }

    public function edit(Request $req)
    {
        return $this->productRepositories->updateData($req);
    }

    public function delete(Request $req)
    {
        return $this->productRepositories->deleteData($req);  
    }
}
