<?php

use App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers\HolidayController;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers\PackageController;
use App\Http\ApiV1\FrontApi\Modules\Locations\Controllers\CityController;
use App\Http\ApiV1\FrontApi\Modules\Locations\Controllers\FilialController;
use App\Http\ApiV1\FrontApi\Modules\Lounges\Controllers\LoungeController;
use App\Http\ApiV1\FrontApi\Modules\Quests\Controllers\QuestController;
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

Route::name('api')->group(function () {
    Route::get('quests/{id}', [QuestController::class, 'get']);
    Route::post('quests:search', [QuestController::class, 'search']);

    Route::get('lounges/{id}', [LoungeController::class, 'get']);
    Route::post('lounges:search', [LoungeController::class, 'search']);

    Route::get('holidays/{id}', [HolidayController::class, 'get']);
    Route::post('holidays:search', [HolidayController::class, 'search']);

    Route::get('cities/{id}', [CityController::class, 'get']);
    Route::post('cities:search', [CityController::class, 'search']);

    Route::get('filials/{id}', [FilialController::class, 'get']);
    Route::post('filials:search', [FilialController::class, 'search']);
});
