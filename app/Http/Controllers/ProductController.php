<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Service\ResponseJsonService;

class ProductController extends Controller
{
    private $responseJsonService;
    private $auth;

    public function __construct(ResponseJsonService $responseJsonService, Auth $auth)
    {
        $this->responseJsonService = $responseJsonService;
        $this->auth = $auth;
    }

    public function index()
    {
        try {
            $data=Product::all();
            return $this->responseJsonService->success($data);
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
        
    }

    public function getListByAdmin()
    {
        try {
            $auth = Auth::guard();

            $data=Product::where('admin_id', $auth->user()->id)->get();
            return $this->responseJsonService->success($data);
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
        
    }

    public function create(Request $req)
    {
        try {
            $req->validate([
                'code' => 'required',
                'price' => 'required',
                'description' => 'required',
                'stock' => 'required'
            ]);

            $data= new Product();
            $auth = Auth::guard();

            $data->code = $req ->code;
            $data->name = $req->name;
            $data->price = $req->price;
            $data->description = $req->description;
            $data->stock = $req->stock;
            $data->sold_out_quantity = 0;
            $data->admin_id = $auth->user()->id;
            $data->image = $req->image;

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
            return response()->json(array(
                'OUT_STAT' => 'T',
                'OUT_MESS' => 'Success'
            ), 200);;
        }
        else if($result == 2){
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Duplicate Product Code'
            ), 500);
        }
        else {
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Failed'
            ), 500);
        }
    }

    public function edit(Request $req)
    {
        try {
            $req->validate([
                'id' => 'required',
                'code' => 'required',
                'price' => 'required',
                'description' => 'required',
                'stock' => 'required'
            ]);

            $data = Product::where('id',$req->id);    
            $result = $data->update(array(
                'code' => $req->code,
                'name' => $req->name,
                'price' => $req->price,
                'description' => $req->description,
                'stock' => $req->stock,
                'image' => $req->image
            ));

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
            return response()->json(array(
                'OUT_STAT' => 'T',
                'OUT_MESS' => 'Success'
            ), 200);;
        }
        else if($result == 2){
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Duplicate Product Code'
            ), 500);
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

            $data = Product::where('id',$req->id);
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
            return $this->responseJsonService->failed('Error');
        }
           
    }
}
