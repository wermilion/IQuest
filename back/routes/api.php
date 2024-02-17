<?php

use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckDishController;
use App\Http\Controllers\Api\CheckDishesController;
use App\Http\Controllers\Api\DishController;
use App\Http\Controllers\Api\OrderController;
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

/**Категории**/
Route::get('/categories', [CategoryController::class, 'index'])->name('api.categories');

/**Блюда**/
Route::get('/dishes', [DishController::class, 'index'])->name('api.dishes');

/**Главный блок**/
Route::get('/main-block', [BlockController::class, 'mainBlock'])->name('api.mainBlock');

/**Получение заказа**/
Route::post('/orders', [OrderController::class, 'store'])->name('api.store');

/**Проверка доступно ли блюдо**/
Route::get('/check-dishes', [CheckDishController::class, 'checkDishes'])->name('api.checkDishes');