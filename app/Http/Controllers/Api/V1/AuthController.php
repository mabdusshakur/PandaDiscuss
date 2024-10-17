<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    /**
     * Summary of userLogin
     * @param \Illuminate\Http\Request $request
     *  - email: string
     * @return \App\Helpers\ResponseHelper::sendSuccess|ResponseHelper::sendError
     */
    function userLogin(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email'
            ]);

            // Get the email address from the request
            $email = $request->input('email');

            // Generate a random 4-digit OTP
            $otp = rand(1000, 9999);

            // Send the OTP to the user's email address

            // Save the OTP in the user table + create or update the user record
            $user = User::updateOrCreate(
                ['email' => $email],
                ['email' => $email, 'otp' => $otp]
            );

            if (!$user) {
                return ResponseHelper::sendError('Failed to create user', null, 500);
            }

            return ResponseHelper::sendSuccess('OTP sent successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError("Failed to login user", $th->getMessage(), 500);
        }
    }

    /**
     * Summary of verifyOtp
     * @param \Illuminate\Http\Request $request
     *  - otp: int
     * @return \App\Helpers\ResponseHelper::sendSuccess|ResponseHelper::sendError
     */
    function verifyOtp(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $request->validate([
                'otp' => 'required|integer',
                'email' => 'required|email'
            ]);

            // Get the email address and OTP from the request
            $email = $request->input('email');
            $otp = $request->input('otp');

            // check if the OTP is not null or zero
            if (!$otp || $otp == 0) {
                return ResponseHelper::sendError('Invalid OTP', null, 400);
            }

            // Find the user record
            $user = User::where('email', $email)->where('otp', $otp)->first();

            if (!$user) {
                return ResponseHelper::sendError('Invalid OTP', null, 400);
            }

            // Update the user record to remove the OTP
            $user->otp = 0;
            $user->save();


            // Login the user and generate a JWT token

            /** @var JWTGuard $auth */
            $auth = auth('api');
            $token = $auth->login($user);

            return ResponseHelper::respondWithToken($token, $user);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError("Failed to verify OTP", $th->getMessage(), 500);
        }
    }

    /**
     * Summary of userLogout
     * @param \Illuminate\Http\Request $request
     * - bearerToken: string - JWT token 
     * @return \App\Helpers\ResponseHelper::sendSuccess|ResponseHelper::sendError
     */
    function userLogout(Request $request)
    {
        try {
            $auth = auth('api');
            $auth->logout();

            return ResponseHelper::sendSuccess('Logout Success', 'Logout Success');
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('User logout failed', 200, $th->getMessage());
        }
    }




    /**
     * @deprecated - This method is not used anymore
     * Summary of broadcastAuth
     * This method is used to authenticate the user for broadcasting
     * @param \Illuminate\Http\Request $request
     * - socket_id: string
     * - channel_name: string
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function broadcastAuth(Request $request)
    {
        $socketId = $request->input('socket_id');
        $channelName = $request->input('channel_name');

        try {
            // Generate the required format for the response
            $stringToAuth = $socketId . ':' . $channelName;
            $hashed = hash_hmac('sha256', $stringToAuth, env('REVERB_APP_SECRET'));
            return response(['auth' => env('REVERB_APP_KEY') . ':' . $hashed]);
        } catch (Exception $e) {
            return response(['message' => 'Cannot authenticate reverb'], 403);
        }
    }
}