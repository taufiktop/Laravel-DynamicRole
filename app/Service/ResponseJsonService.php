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

    // public function success1($message = 'Success')
    // {
    //     return response()->json(array(
    //         'items' => $data,
    //         'page_size' => 10,
    //         'page'  => 1,
    //         'total' => 120
    //     ), 200);
    // }

    // public function error($message = 'Error')
    // {
    //     return response()->json(array(
    //         'error' => [
    //             'code' => 'SY-401',
    //             'message'  => 1
    //         ]
    //     ), 500);
    // }
}