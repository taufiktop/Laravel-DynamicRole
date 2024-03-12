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
        $this->middleware(['permission:read orders']);
        $this->middleware(['permission:create orders'])->only('create');
        $this->middleware(['permission:update orders'])->only('cancel','checkout');
    }

    public function index ()
    {
        return $this->orderRepositories->getData();
    }

    public function create (Request $req)
    {
        return $this->orderRepositories->addData($req);
    }

    public function cancel (Request $req)
    {
        return $this->orderRepositories->cancelData($req);
    }

    public function checkout (Request $req)
    {
        return $this->orderRepositories->checkoutData($req);
    }
}
