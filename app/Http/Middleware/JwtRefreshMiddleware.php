<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtRefreshMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for token requested.
        if (!JWTAuth::getToken()) {
            if ($request->acceptsJson() || $request->expectsJson()) {
                return JsonResponse::create([
                    'error' => \Lang::get('auth.token_not_provided')
                ], Response::HTTP_UNAUTHORIZED);
            } else
                throw new BadRequestHttpException('Token not provided');
        }

        try {

            // Refresh the token requested.
            $newToken = JWTAuth::refresh();

        } catch (TokenBlacklistedException $e) {
            return JsonResponse::create([
                'error' => \Lang::get('auth.token_blacklisted')
            ], Response::HTTP_UNAUTHORIZED);
        } catch (TokenExpiredException $e) {
            return JsonResponse::create([
                'error' => \Lang::get('auth.token_expired')
            ], 419);
        } catch (JWTException $e) {
            if ($request->acceptsJson() || $request->expectsJson()) {
                return JsonResponse::create([
                    'error' => \Lang::get('auth.token_absent')
                ], Response::HTTP_UNAUTHORIZED);
            } else
                throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }


        // Defined response header.
        $response = $next($request);

        // Send the refreshed token back to the client.
        return $this->setAuthenticationHeader($response, $newToken);
    }
}
