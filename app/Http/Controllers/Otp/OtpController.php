<?php

namespace App\Http\Controllers\Otp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OtpRepositories;

class OtpController extends Controller
{
    private $otpRepositories;

    public function __construct(OtpRepositories $otpRepositories)
    {
        $this->otpRepositories = $otpRepositories;
    }

    public function sendOtp(Request $req)
    {
        return $this->otpRepositories->sendOtp($req);
    }

    public function verifyOtp(Request $req)
    {
        return $this->otpRepositories->verifyOtp($req);
    }
}
