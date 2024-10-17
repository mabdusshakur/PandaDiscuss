<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTGuard;

class ResponseHelper
{
    /**
     * Summary of sendSuccess
     * @param mixed $message - success message
     * @param mixed $result - data to be returned in the response
     * @param mixed $statusCode - status code, default is 200
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public static function sendSuccess($message, $result, $statusCode = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            // 'data' => $result,
            $result,
        ];
        return response()->json($response, $statusCode);
    }


    /**
     * Summary of sendError
     * @param mixed $message - error message
     * @param mixed $statusCode - error status code, default is 400
     * @param mixed $errors - error data array
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public static function sendError($message, $errors = [], $statusCode = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];

        return response()->json($response, $statusCode);
    }


    /**
     * Summary of respondWithToken
     * @param mixed $token
     * @param mixed $guard - default is 'api'
     * @return JsonResponse|mixed
     */
    public static function respondWithToken($token, $user = null, $guard = 'api')
    {
        /** @var JWTGuard $auth*/
        $auth = auth($guard);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $auth->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }
}