<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Summary of updateUser
     * @param \Illuminate\Http\Request $request
     *  - name: string
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        // Get the authenticated user ID
        $auth_id = auth('api')->user()->id;

        $user = User::where('id', $auth_id)->first();
        if ($user) {
            $user->update([
                'name' => $request->name
            ]);
            return ResponseHelper::sendSuccess('User updated successfully', $user, 200);
        } else {
            return ResponseHelper::sendError('User not found', [], 404);
        }
    }

    /**
     * Summary of getUsersList
     * @param \Illuminate\Http\Request $request
     * - auth: int (Authenticated user ID) - This is automatically added by the @file \JwtMiddleware.php
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getUsersList(Request $request)
    {
        // Get the authenticated user ID
        $auth_id = auth('api')->user()->id;

        // Get all users except the authenticated user
        $users = User::whereNot('id', $auth_id)->get();

        return ResponseHelper::sendSuccess('Users fetched successfully', $users, 200);
    }
}