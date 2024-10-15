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

        $user = User::where('id', $request->auth)->first();
        if ($user) {
            $user->update([
                'name' => $request->name
            ]);
            return ResponseHelper::sendSuccess('User updated successfully', $user, 200);
        } else {
            return ResponseHelper::sendError('User not found', [], 404);
        }
    }
}