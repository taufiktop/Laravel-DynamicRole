<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(array(
            'OUT_STAT' => 'F',
            'OUT_MESS' => 'Unauthorized'
        ), 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            return response()->json(array(
                'OUT_STAT' => 'S',
                'OUT_MESS' => 'Success',
                'OUT_DATA' => $this->guard()->user()
            ), 200);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $this->guard()->logout();
            return response()->json([
                'OUT_STAT' => 'S',
                'OUT_MESS' => 'Successfully logged out'
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function register(Request $req)
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
            $data->role = $req ->role;
            $data->name = $req->name;
            $data->email = $req->email;
            $data->phone_number = $req->phone_number;
            $data->password = Hash::make($req->password);

            $result = $data->save();

            DB::commit();

            return response()->json([
                'OUT_STAT' => 'S',
                'OUT_MESS' => 'Successfully register'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Error'
            ), 500);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        

        // Decode the token
        // $token = 'your_jwt_token_here';
        // $user = JWTAuth::toUser($token);


        return response()->json([
            'OUT_STAT' => 'S',
            'OUT_MESS' => 'Success',
            'OUT_DATA' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->guard()->factory()->getTTL() * 60,
                // 'users' => $user
            ]
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
