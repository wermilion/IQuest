<?php

namespace App\Http\Controllers\Api;

use App\Enums\ErrorEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\DishFilter;
use App\Http\Filters\PostFilter;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\DishResource;
use App\Models\Dish;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class DishController extends Controller
{
    public function index(FilterRequest $request)
    {
        try {
            $data = $request->validated();
            $filter = app()->make(DishFilter::class, ['queryParams' => array_filter($data, function ($value) {
                return !(is_null($value) or '' === $value);
            })]);
            return DishResource::collection(Dish::filter($filter)->orderByDesc('id')->get());
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            return response([
                'success' => false,
                'message' => ErrorEnum::UNKNOWN->value,
            ])->setStatusCode(500);
        }
    }
}
