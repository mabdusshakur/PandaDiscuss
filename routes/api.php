<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ChatController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Broadcast::routes(['middleware' => ['auth:api']]);

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| This routes handles, userLogin, verifyOtp, userLogout 
|
*/

Route::post('/login', [AuthController::class, 'userLogin']);
Route::post('/verify', [AuthController::class, 'verifyOtp'])->name('verify');
Route::post('/logout', [AuthController::class, 'userLogout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Chat Routes
|--------------------------------------------------------------------------
|
| This routes handles, createConversation, sendMessage, getMessages, getUsersList
|
*/

Route::middleware('auth:api')->group(function () {
    Route::post('/conversation', [ChatController::class, 'createConversation']);
    Route::post('/conversation/{conversationId}/message', [ChatController::class, 'sendMessage']);
    Route::get('/conversation/{conversationId}/messages', [ChatController::class, 'getMessages']);
    Route::get('/users', [UserController::class, 'getUsersList']);
    Route::patch('/users', [UserController::class, 'updateUser']);
});