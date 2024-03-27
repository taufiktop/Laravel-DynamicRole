<?php

namespace App\Service;

class ResponseJsonService
{
    public function success($data = [], $message = 'Success')
    {
        return response()->json(array(
            'status' => 'SY-200',
            'message' => $message,
            'data' => $data,
            'total_data' => count($data)
        ), 200);
    }

    public function failed($message = 'Failed', $status = 500)
    {
        return response()->json(array(
            'status' => 'SY-'.$status,
            'message' => $message
        ), $status);
    }

}