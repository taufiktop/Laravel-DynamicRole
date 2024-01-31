<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Database\QueryException;

class CartController extends Controller
{
    public function index ()
    {
        try {
            $auth = Auth::guard();
            $data = DB::table('carts')
                ->join('products', 'carts.product_code', '=', 'products.code')
                ->where('client_id', $auth->user()->id)
                ->get();

            if(count($data)>0) {
                return response()->json(array(
                    'OUT_STAT' => 'T',
                    'OUT_MESS' => 'Success',
                    'OUT_DATA' => $data,
                    'TOTAL_DATA' => count($data)
                ), 200);
            }
            else {
                return response()->json(array(
                    'OUT_STAT' => 'T',
                    'OUT_MESS' => 'Success',
                    'OUT_DATA' => [],
                    'TOTAL_DATA' => count($data)
                ), 200);
            }
        } catch (\Throwable $th) {
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Error'
            ), 500);
        }
            
        
    }

    public function create(Request $req)
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
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Error'
            ), 500);
        }

        if($result == 1){
            return response()->json(array(
                'OUT_STAT' => 'T',
                'OUT_MESS' => 'Success'
            ), 200);;
        }
        else if($result == 2){//If Duplicate Product Code, the update quantity
            try {
                $data = Cart::where('product_code',$req->product_code);    
                $result = $data->update(array(
                    'quantity' => $req->quantity
                ));
                if($result == 1){
                    return response()->json(array(
                        'OUT_STAT' => 'T',
                        'OUT_MESS' => 'Success Update Quantity'
                    ), 200);;
                }
                else if($result == 0){
                    return response()->json(array(
                        'OUT_STAT' => 'F',
                        'OUT_MESS' => 'Id not found'
                    ), 500);
                }

            } catch (\Throwable $th) {
                return response()->json(array(
                    'OUT_STAT' => 'F',
                    'OUT_MESS' => 'Error'
                ), 500);
            }
        }
        else {
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Failed'
            ), 500);
        }
        
    }


    public function edit (Request $req) 
    {
        try {
            $req->validate([
                'id' => 'required',
                'quantity' => 'required'
            ]);

            $data= new Cart();

            $data = Cart::where('id',$req->id);    
            $result = $data->update(array(
                'quantity' => $req->quantity
            ));
        } catch (\Throwable $th) {
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Error'
            ), 500);
        }

        if($result == 1){
            return response()->json(array(
                'OUT_STAT' => 'T',
                'OUT_MESS' => 'Success'
            ), 200);;
        }
        else if($result == 0){
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Id not found'
            ), 500);
        }
        else {
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Failed'
            ), 500);
        }
    }


    public function delete(Request $req)
    {
        try {
            $req->validate([
                'id' => 'required'
            ]);

            $data = Cart::where('id',$req->id);
            $data = $data->delete();

            if($data>0){
                return response()->json(array(
                    'OUT_STAT' => 'T',
                    'OUT_MESS' => 'Success'
                ), 200);
            }
            else{
                return response()->json(array(
                    'OUT_STAT' => 'F',
                    'OUT_MESS' => 'Id not found'
                ), 500);
            }

        } catch (\Throwable $th) {
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Error'
            ), 500);
        }
           
    }
}
