<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\Product;
use App\Service\ResponseJsonService;
use Carbon\Carbon;

class OrderRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function getData()
    {
        try {
            $auth = Auth::guard();
            
            $data=Order::where('client_id', $auth->user()->id)
                ->where('payment_status', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

            return $this->responseJsonService->success($data);
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
    }

    public function addData($req)
    {
        try {
            $arrayProductCode = [];
            for($i=0; $i<count($req->order); $i++)
            {
                array_push($arrayProductCode,$req->order[$i]['product_code']);
            }

            $dataByProduct = DB::table('products')
                    ->whereIn('code', $arrayProductCode)
                    ->select('id', 'code', 'name', 'stock', 'price')
                    ->get();

            $flagReadyStock = true;
            $order = $req->order;
            $totalAmount = 0;
            $adminFee = 1000; //Default 1000
            for($i=0; $i<count($order); $i++)
            {
                // for($j=0; $j<count($dataByProduct); $j++)
                // {
                    if($order[$i]['product_code'] == $dataByProduct[$i]->code && $order[$i]['quantity'] > $dataByProduct[$i]->stock)
                    {
                        $flagReadyStock = false;
                    }
                // }
                
                $order[$i]['sub_total'] = $order[$i]['quantity'] * $dataByProduct[$i]->price;
                $totalAmount = $totalAmount + $order[$i]['sub_total'];
            }

            if($flagReadyStock)
            {
                $data= new Order();
                $auth = Auth::guard();

                // $id = DB::table('orders')->insertGetId(
                //     [
                //         'client_id' => $auth->user()->id, 
                //         'total_amount' => $totalAmount, 
                //         'admin_fee' => $adminFee,  //default 1000
                //         'virtual_number' => rand(100,999) . time(), 
                //         'payment_status' => 0, //0 untuk menunggu pembayaran
                //         'created_at' => Carbon::now('Asia/Jakarta')
                //     ]
                // );

                $data->client_id = $auth->user()->id;
                $data->total_amount = $totalAmount;
                $data->admin_fee = $adminFee; //default 1000
                $data->virtual_number = rand(100,999) . time();
                $data->payment_status = 0; //0 untuk menunggu pembayaran
                $data->save();
                $id = $data->id;

                if($id)
                {
                    for($i=0; $i<count($order); $i++)
                    {
                        
                        $data = new OrderDetail();
                        $data->order_id = $id;
                        $data->product_id = $dataByProduct[$i]->id;
                        $data->product_code = $order[$i]['product_code'];
                        $data->product_name = $dataByProduct[$i]->name;
                        $data->quantity = $order[$i]['quantity'];
                        $data->unit_price = $dataByProduct[$i]->price;
                        $data->sub_total = $order[$i]['sub_total'];
                        $resultOrderDetailInsert = $data->save();

                        if($resultOrderDetailInsert == 1)
                        {
                            $data = Cart::where('product_code', $order[$i]['product_code'])->delete();
                        }
                    }
                
                }

                return $this->responseJsonService->success();
            }
            else
            {
                return $this->responseJsonService->failed('Stock not Ready');
            }
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
    }

    public function cancelData($req)
    {
        try {
            $req->validate([
                'id' => 'required'
            ]);

            $data= new Order();

            $data = Order::where('id',$req->id);    
            $result = $data->update(array(
                'payment_status' => 1 // flag 1 is cancel
            ));
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }

        if($result == 1){
            return $this->responseJsonService->success();
        }
        else if($result == 0){
            return $this->responseJsonService->failed('Id not found');
        }
        else {
            return $this->responseJsonService->failed('Failed');
        }
    }

    public function checkoutData($req)
    {
        try {
            $req->validate([
                'id' => 'required'
            ]);

            $data= new Order();

            $dataOrder = $data->where('id',$req->id)->get();

            if(count($dataOrder) == 1)
            {
                //Check order is paid or not
                if($dataOrder[0]->payment_status == 2)
                {
                    return $this->responseJsonService->failed('Order is paid');
                }
                else if($dataOrder[0]->payment_status == 1)
                {
                    return $this->responseJsonService->failed('Order is cancelled');
                }
                else if($dataOrder[0]->payment_status == 0)
                {
                    //Start Check stock
                    $auth = Auth::guard();
                    $dataOrderDetail = DB::table('orders')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->where('client_id', $auth->user()->id)
                        ->where('orders.id', $req->id)
                        ->get();

                    $arrayProductCodeOrder = [];
                    for($i=0; $i<count($dataOrderDetail); $i++)
                    {
                        array_push($arrayProductCodeOrder, $dataOrderDetail[$i]->product_code);
                    }

                    $dataByProduct = DB::table('products')
                            ->whereIn('code', $arrayProductCodeOrder)
                            ->select('id', 'code', 'name', 'stock', 'price', 'sold_out_quantity')
                            ->get();

                    $flagReadyStock = true;
                    for($i=0; $i<count($dataOrderDetail); $i++)
                    {
                        // for($j=0; $j<count($dataByProduct); $j++)
                        // {
                            if($dataOrderDetail[$i]->product_code == $dataByProduct[$i]->code && $dataOrderDetail[$i]->quantity > $dataByProduct[$i]->stock)
                            {
                                $flagReadyStock = false;
                            }
                        // }
                        
                    }
                    //end check stock
                    

                    if ($flagReadyStock)
                    {
                        for($i=0; $i<count($dataOrderDetail); $i++)
                        {
                            $data= new Product();

                            $data = Product::where('code',$dataByProduct[$i]->code);    
                            $result = $data->update(array(
                                'stock' => ($dataByProduct[$i]->stock - $dataOrderDetail[$i]->quantity),
                                'sold_out_quantity' => ($dataByProduct[$i]->sold_out_quantity + $dataOrderDetail[$i]->quantity)
                            ));
                        }

                        foreach ($dataOrder as $order) {
                            $order->payment_status = 2; // after chekckout, update flag into 2
                            // Save the changes to the database
                            $order->save();
                        }
                        return $this->responseJsonService->success();
                    }
                    else
                    {
                        return $this->responseJsonService->failed('Stock not Ready');
                    }
                }
                else
                {
                    return $this->responseJsonService->failed('Fictitious Orders');
                }

            }
            else
            {
                return $this->responseJsonService->failed('Id not found');
            }
            
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
    }

}