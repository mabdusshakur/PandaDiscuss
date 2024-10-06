<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;


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