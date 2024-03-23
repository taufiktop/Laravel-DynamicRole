<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Service\ResponseJsonService;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
use App\Models\User;

class OtpRepositories
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

    public function sendOtp($req)
    {
       try {
            $req->validate([
                'name' => 'required',
                'phone_number' => 'required'
            ]);

            $otp = mt_rand(100000, 999999); // Generate a 6-digit OTP
            $expiryTime = now()->addSeconds(6000); // Set OTP expiration time to 15 minutes from now

            User::updateOrCreate(
                ['phone_number'      => $req->phone_number],
                [
                    'name'              => $req->name,
                    'role'              => 'customer',
                    'otp'               => $otp,
                    'otp_expired_at'    => $expiryTime,
                ]
            );

            return $this->responseJsonService->success();
        } catch (\Exception $e) {
            return $this->responseJsonService->failed($e->getMessage(), $e->getStatusCode());
        }
    }

    public function verifyOtp($req)
    {
        $req->validate([
            'phone_number' => 'required',
            'otp' => 'required',
        ]);

        $user = User::where('phone_number', $req->phone_number)
            ->where('otp', $req->otp);
            
        if ($user->first()) {
            // OTP is valid
            if($userFirst = $user->where('otp_expired_at', '>=', now())->first())
            {
                $token = JWTAuth::fromUser($userFirst);
                return $this->respondWithToken($token);
            }
            else
            {
                return $this->responseJsonService->failed('Expired Otp');
            }
        } else {
            return $this->responseJsonService->failed('Invalid Otp');
        }
    }

    protected function respondWithToken($token)
    {
        $data = array([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
        ]);

        return $this->responseJsonService->success($data);
    }

    public function guard()
    {
        return Auth::guard();
    }
}