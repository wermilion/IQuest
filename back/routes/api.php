<?php

use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserAuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get(
    '/csrf-cookie',
    CsrfCookieController::class.'@show'
)->middleware('web')->name('sanctum.csrf-cookie');
