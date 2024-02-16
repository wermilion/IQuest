<?php

use App\Http\ApiV1\FrontApi\Modules\Cities\Controllers\CitiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('cities', [CitiesController::class, 'create']);
Route::get('cities/{id}', [CitiesController::class, 'get']);
Route::delete('cities/{id}', [CitiesController::class, 'delete']);
Route::put('cities/{id}', [CitiesController::class, 'update']);
Route::post('cities:search', [CitiesController::class, 'search']);
