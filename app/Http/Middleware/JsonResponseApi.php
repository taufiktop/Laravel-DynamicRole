<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonResponseApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if($response instanceof \Illuminate\Http\JsonResponse){
            $response->withHeaders([
                'Content-Type' => 'application/json',
                'X-Content-Type-Options'=>'nosniff',
                'X-XSS-Protection'=> '1; mode=block',
                'Strict-Transport-Security'=> 'max-age=31536000; includeSubDomains; preload',
                'X-Frame-Options'=>'SAMEORIGIN'
            ]);
        }
        return $response;
    }
}
