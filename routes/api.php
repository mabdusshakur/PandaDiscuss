<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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