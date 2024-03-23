<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Service\ResponseJsonService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function getListMenu ()
    {
        try {
            $data = array(
                [
                    "uuid" => "9b9ecce3-dd8c-4756-b202-d4d9f9e6a994",
                    "categoryUuid" => array(
                        "9b9ecce3-dd8c-4756-b202-d4d9f9e6a994", 
                        "9b9ecce3-dd8c-4756-b202-d4d9f9e6a993",
                    ),
                    "name"  => "Sushi Muratte Platter",
                    "price" => "30000",
                    "description" => "Lorem ipsum",
                    "image" => "Lorem ipsum"
                ],
                [
                    "uuid" => "9b9ecce3-dd8c-4756-b202-d4d9f9e6a994",
                    "categoryUuid" => array(
                        "9b9ecce3-dd8c-4756-b202-d4d9f9e6a994", 
                        "9b9ecce3-dd8c-4756-b202-d4d9f9e6a991",
                    ),
                    "name"  => "Sushi Muratte Platter",
                    "price" => "30000",
                    "description" => "Lorem ipsum",
                    "image" => "Lorem ipsum"
                ],
            );

            return $this->responseJsonService->success($data);
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function getListCategory ()
    {
        try {
            $data = array(
                [
                    "uuid" => "9b9ecce3-dd8c-4756-b202-d4d9f9e6a994",
                    "name"  => "Promo"
                ],
                [
                    "uuid" => "9b9ecce3-dd8c-4756-b202-d4d9f9e6a993",
                    "name"  => "Sushi Platter"
                ],
                
                [
                    "uuid" => "9b9ecce3-dd8c-4756-b202-d4d9f9e6a992",
                    "name"  => "Sushi Roll"
                ],
                [
                    "uuid" => "9b9ecce3-dd8c-4756-b202-d4d9f9e6a991",
                    "name"  => "Appetizer"
                ],
                [
                    "uuid" => "9b9ecce3-dd8c-4756-b202-d4d9f9e6a990",
                    "name"  => "Drinks"
                ],
            );
    
            return $this->responseJsonService->success($data);
        } catch (\Exception $th) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

}