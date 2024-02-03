<?php

namespace App\Service;

class ResponseJsonService
{
    public function success($data = [], $message = 'Success', )
    {
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
    }

    public function failed($message = 'Failed')
    {
        return response()->json(array(
            'OUT_STAT' => 'F',
            'OUT_MESS' => $message
        ), 500);
    }
}