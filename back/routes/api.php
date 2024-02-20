<?php

use App\Http\ApiV1\FrontApi\Modules\Bookings\Controllers\BookingsController;
use App\Http\ApiV1\FrontApi\Modules\Certificates\Controllers\CertificateTypesController;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers\HolidaysController;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers\PackagesController;
use App\Http\ApiV1\FrontApi\Modules\Locations\Controllers\CitiesController;
use App\Http\ApiV1\FrontApi\Modules\Locations\Controllers\FilialsController;
use App\Http\ApiV1\FrontApi\Modules\Lounges\Controllers\LoungesController;
use App\Http\ApiV1\FrontApi\Modules\Quests\Controllers\QuestsController;
use App\Http\ApiV1\FrontApi\Modules\Schedules\Controllers\ScheduleQuestsController;
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

Route::get('quests/{id}', [QuestsController::class, 'get']);
Route::post('quests:search', [QuestsController::class, 'search']);

Route::get('schedule_quests/{id}', [ScheduleQuestsController::class, 'get']);
Route::post('schedule_quests:search', [ScheduleQuestsController::class, 'search']);

Route::get('lounges/{id}', [LoungesController::class, 'get']);
Route::post('lounges:search', [LoungesController::class, 'search']);

Route::get('holidays/{id}', [HolidaysController::class, 'get']);
Route::post('holidays:search', [HolidaysController::class, 'search']);

Route::get('packages/{id}', [PackagesController::class, 'get']);
Route::post('packages:search/{holiday}', [PackagesController::class, 'search']);

Route::get('certificate_types/{id}', [CertificateTypesController::class, 'get']);
Route::post('certificate_types:search', [CertificateTypesController::class, 'search']);

Route::get('cities/{id}', [CitiesController::class, 'get']);
Route::post('cities:search', [CitiesController::class, 'search']);

Route::get('filials/{id}', [FilialsController::class, 'get']);
Route::post('filials:search', [FilialsController::class, 'search']);

Route::post('bookings/create', [BookingsController::class, 'create']);
