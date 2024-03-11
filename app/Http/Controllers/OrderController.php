<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrderRepositories;

class OrderController extends Controller
{
    private $orderRepositories;

    public function __construct(OrderRepositories $orderRepositories)
    {
        $this->orderRepositories = $orderRepositories;
    }

    public function index ()
    {
        $this->middleware(['permission:read order']);
        return $this->orderRepositories->getData();
    }

    public function create (Request $req)
    {
        $this->middleware(['permission:create order']);
        return $this->orderRepositories->addData($req);
    }

    public function cancel (Request $req)
    {
        $this->middleware(['permission:update order']);
        return $this->orderRepositories->cancelData($req);
    }

    public function checkout (Request $req)
    {
        $this->middleware(['permission:update order']);
        return $this->orderRepositories->checkoutData($req);
    }
}
