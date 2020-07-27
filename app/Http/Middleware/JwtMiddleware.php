<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof Exceptions\TokenInvalidException) {
                $response = ['error' => true, 'message' => 'Такого пользователя не существует, переавторизуйтесь'];
            } elseif ($e instanceof Exceptions\TokenExpiredException) {
                $response = ['error' => true, 'message' => 'Вермя авторизации вышло'];
            } else {
                $response = ['error' => true, 'message' => 'Вы не авторизированы'];
            }

            return response()->json($response, 401);
        }

        return $next($request);
    }
}
