<?php

use App\Models\User;
use App\Helpers\JWTToken;
use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Broadcast;

// Home Route
Route::get('/', [PageController::class, 'homePage'])->name('home');


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes handle user authentication, including login and verification.
|
*/
Route::get('/login', [PageController::class, 'loginPage'])->name('login');
Route::get('/verify', [PageController::class, 'verifyPage'])->name('verify');


/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| These routes are for the user dashboard.
|
*/
Route::get('/dashboard', [PageController::class, 'dashboardPage'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
|
| These routes are for the user profile.
|
*/
Route::get('/profile', [PageController::class, 'profilePage'])->name('profile');




/*
|--------------------------------------------------------------------------
| Laravel Echo Server Routes
|--------------------------------------------------------------------------
|
| This route is used to authenticate users for the Laravel Echo Server.
|
*/
Route::post('/broadcasting/auth', [AuthController::class, 'broadcastAuth']);