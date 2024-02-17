<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function store(OrderRequest $request, OrderService $orderService)
    {
        return $orderService->storeOrderInfo($request);
    }
}
