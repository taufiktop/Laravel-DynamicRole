<?php

namespace App\Service;

class ResponseJsonService
{
    public function success($data = [], $message = 'Success')
    {
        if(count($data)>0) {
            return response()->json(array(
                'OUT_STAT' => 'T',
                'OUT_MESS' => $message,
                'OUT_DATA' => $data,
                'TOTAL_DATA' => count($data)
            ), 200);
        }
        else {
            return response()->json(array(
                'OUT_STAT' => 'T',
                'OUT_MESS' => $message,
                'OUT_DATA' => [],
                'TOTAL_DATA' => count($data)
            ), 200);
        }
    }

    public function failed($message = 'Failed')
    {
        return response()->json(array(
            'OUT_STAT' => 'F',
            'OUT_MESS' => $message
        ), 500);
    }

    public function sucess1($message = 'sucess')
    {
        return response()->json(array(
            'items' => $data,
            'page_size' => 10,
            'page'  => 1,
            'total' => 120
        ), 200);
    }

    public function sucess2($message = 'sucess')
    {
        return response()->json(array(
            'items' => $data,
            'page_size' => 10,
            'page'  => 1,
            'total' => 120
        ), 200);
    }

    public function error($message = 'error')
    {
        return response()->json(array(
            'error' => [
                'code' => 'SY-401',
                'message'  => 1
            ]
        ), 500);
    }
}