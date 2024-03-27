<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Service\ResponseJsonService;
use App\Helpers\HttpClient;

class ExampleRepositories
{
    private $responseJsonService;
    private $httpClient;

    public function __construct(ResponseJsonService $responseJsonService, HttpClient $httpClient)
    {
        $this->responseJsonService = $responseJsonService;
        $this->httpClient = $httpClient;
    }

    public function get ()
    {
        try {
            $response = $this->httpClient->get(config('api.example'));
            return $this->responseJsonService->success($response);
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function post ()
    {
        try {
            $data = [
                "question" => request()->question,
                "choices" => request()->choices
            ];

            return $data;

            $response = $this->httpClient->post(config('api.example'), $data);
            return $this->responseJsonService->success([$response]);
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage());
        }
    }
}