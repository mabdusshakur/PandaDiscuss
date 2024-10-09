<?php

namespace App\Http\Middleware;

use App\Helpers\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided.'], 401);
        }

        $credentials = JWTToken::decodeToken($token);
        if ($credentials === 'Unauthorized') {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        $request['auth'] = $credentials->sub;
        return $next($request);
    }
}