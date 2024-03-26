<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use Sentry;
use App\Service\ResponseJsonService;
use App\Models\User;

class AuthRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function login($req)
    {
        $credentials = $req->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return $this->responseJsonService->failed('Unauthorized', 401);
    }

    public function me()
    {
        try {
            $data = $this->guard()->user();
            return $this->responseJsonService->success($data);
        } catch (\Exception $th) {
            Sentry::captureException($e);
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function logout()
    {
        try {
            $this->guard()->logout();
            return $this->responseJsonService->success('Successfully logged out');
        } catch (\Exception $th) {
            Sentry::captureException($e);
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function register($req)
    {
        try {
            $req->validate([
                'role' => 'required',
                'name' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'password' => 'required'
            ]);

            DB::beginTransaction();

            $data= new User();
            $data->role = $req ->role ?: 'customer';
            $data->name = $req->name;
            $data->phone_number = $req->phone_number;
            $data->password = Hash::make($req->password);
            $result = $data->save();

            DB::commit();

            return $this->responseJsonService->success('Successfully register');
        } catch (\Exception $e) {
            DB::rollback();
            Sentry::captureException($e);
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    public function refresh($req)
    {
        try {
            return $this->respondWithToken($this->guard()->refresh());
        }catch (\Exception $e) {
            Sentry::captureException($e);
            return $this->responseJsonService->failed($e->getMessage());
        }
    }

    protected function respondWithToken($token)
    {
        $data = array([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

}