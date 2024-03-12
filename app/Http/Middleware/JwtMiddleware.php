<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\JWT;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'OUT_STAT' => 'F',
                    'OUT_MESS' => 'Token is Invalid'
                ],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'OUT_STAT' => 'F',
                    'OUT_MESS' => 'Token is Expired'
                ],401);
            }else{
                return response()->json([
                    'OUT_STAT' => 'F',
                    'OUT_MESS' => 'Authorization Token not found'
                ],401);
            }
        }
        //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
        // if ($user && in_array($user->role, $roles)) {
        if ($user) {
            return $next($request);

        }
        

        return $this->unauthorized();
    }

    private function unauthorized($message = null){
        return response()->json([
            'OUT_STAT' => 'F',
            'OUT_MESS' => $message ? $message : 'You are unauthorized to access this resource'
        ], 401);
    }
}
