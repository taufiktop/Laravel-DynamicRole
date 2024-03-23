<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestApiMiddleware
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
        $API_KEY = 'Password1!';
        $preventAttack = [
            'Content-Type' => 'application/json',
            'X-Content-Type-Options'=>'nosniff',
            'X-XSS-Protection'=> '1; mode=block',
            'Strict-Transport-Security'=> 'max-age=31536000; includeSubDomains; preload',
            'X-Frame-Options'=>'SAMEORIGIN'
        ];
        
        if($API_KEY != $request->header('APIKey')){
            return response()->json(array(
                'status' => 'SY-401',
                'message' => 'Invalid Key'
            ), 401);
        }

        if($preventAttack['Content-Type'] != $request->header('Content-Type')
            || $preventAttack['X-Content-Type-Options'] != $request->header('X-Content-Type-Options')
            || $preventAttack['X-XSS-Protection'] != $request->header('X-XSS-Protection')
            || $preventAttack['Strict-Transport-Security'] != $request->header('Strict-Transport-Security')
            || $preventAttack['X-Frame-Options'] != $request->header('X-Frame-Options')
        ) {
            return response()->json(array(
                'status' => 'SY-403',
                'message' => 'Forbidden'
            ), 403);
        }

        return $next($request);
    }
}
