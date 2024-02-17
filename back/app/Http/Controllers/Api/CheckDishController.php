<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckDishAvailableRequest;
use App\Models\Dish;
use App\Services\DishServices;

class CheckDishController extends Controller
{
    public function checkDishes(CheckDishAvailableRequest $request, DishServices $dishServices)
    {
        $dishes = $request->validated();
        $availableDishes = [];
        foreach ($dishes['arr'] as $dish) {
            if (!Dish::query()->firstWhere('id', $dish)) {
                continue;
            }
            if ($dishServices->checkAvailable($dish)) {
                $availableDishes[] = $dish;
            }
        }
        return response([
            'data' => $availableDishes
        ]);
    }

}
