<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Service\ResponseJsonService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cart;

class CartRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function getDataByClient ()
    {
        try {
            $auth = Auth::guard();
            $data = DB::table('carts')
                ->join('products', 'carts.product_code', '=', 'products.code')
                ->where('client_id', $auth->user()->id)
                ->get();

            return $this->responseJsonService->success($data);
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
    }

    public function addData ($req)
    {
        try {
            $req->validate([
                'product_code' => 'required',
                'quantity' => 'required'
            ]);

            $data= new Cart();
            $auth = Auth::guard();

            $data->client_id = $auth->user()->id;
            $data->product_code = $req ->product_code;
            $data->quantity = $req->quantity;

            $result = $data->save();

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                $result = 2;
            }
            else{
                $result = 3;
            }
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }

        if($result == 1){
            return $this->responseJsonService->success();
        }
        else if($result == 2){//If Duplicate Product Code, update the quantity
            try {
                $data = Cart::where('product_code',$req->product_code);    
                $result = $data->update(array(
                    'quantity' => $req->quantity
                ));
                
                if($result == 1){
                    return $this->responseJsonService->success([], 'Success Update Quantity');
                }
                else if($result == 0){
                    return $this->responseJsonService->failed('Id not found');
                }

            } catch (\Throwable $th) {
                return $this->responseJsonService->failed('Error');
            }
        }
        else {
            return $this->responseJsonService->failed();
        }
    }

    public function updateData ($req)
    {
        try {
            $req->validate([
                'id' => 'required',
                'quantity' => 'required'
            ]);

            $data = Cart::where('id',$req->id);    
            $result = $data->update(array(
                'quantity' => $req->quantity
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
            return $this->responseJsonService->failed();
        }
    }

    public function deleteData ($req)
    {
        try {
            $req->validate([
                'id' => 'required'
            ]);

            $data = Cart::where('id',$req->id);
            $result = $data->delete();

            if($result>0){
                return $this->responseJsonService->success();
            }
            else{
                return $this->responseJsonService->failed('Id not found');
            }

        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
    }
}