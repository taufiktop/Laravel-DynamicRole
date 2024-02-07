<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Service\ResponseJsonService;

class ProductRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function getAllData()
    {
        try {
            $data = Product::all();
            
            return $this->responseJsonService->success($data);
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
        
    }

    public function getDataByAdmin()
    {
        try {
            $auth = Auth::guard();
            $data = Product::where('admin_id', $auth->user()->id)->get();

            return $this->responseJsonService->success($data);
        } catch (\Throwable $th) {
            return $this->responseJsonService->failed('Error');
        }
    }

    public function addData($req)
    {
        try {
            $req->validate([
                'code' => 'required',
                'price' => 'required',
                'description' => 'required',
                'stock' => 'required'
            ]);

            $data = new Product();
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
            return $this->responseJsonService->success();
        }
        else if($result == 2){
            return $this->responseJsonService->failed('Duplicate Product Code');
        }
        else {
            return $this->responseJsonService->failed('Failed');
        }
    }

    public function updateData($req)
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
            return $this->responseJsonService->success();
        }
        else if($result == 2){
            return $this->responseJsonService->failed('Duplicate Product Code');
        }
        else if($result == 0){
            return $this->responseJsonService->failed('Id not found');
        }
        else {
            return $this->responseJsonService->failed('Failed');
        }
    }

    public function deleteData($req)
    {
        try {
            $req->validate([
                'id' => 'required'
            ]);

            $data = Product::where('id',$req->id);
            $data = $data->delete();

            if($data>0){
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