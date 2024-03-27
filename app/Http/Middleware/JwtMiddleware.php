<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\JWT;
use Sentry;
use App\Service\ResponseJsonService;

class JwtMiddleware extends BaseMiddleware
{
    private $responseJsonService;

    public function __construct(ResponseJsonService $responseJsonService)
    {
        $this->responseJsonService = $responseJsonService;
    }

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
            Sentry::captureException($e);
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->responseJsonService->failed('Token is Invalid',401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->responseJsonService->failed('Token is Expired',401);
            } else{
                return $this->responseJsonService->failed('Authorization Token not found',401);
            }
        }

        if ($user) {
            return $next($request);

        }
        
        return $this->unauthorized();
    }

    private function unauthorized(){
        $message = 'Authorization Token not found';
        Sentry::captureException($message);
        return $this->responseJsonService->failed($message,401);
    }
}
