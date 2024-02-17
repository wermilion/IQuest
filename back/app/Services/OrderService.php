<?php

namespace App\Services;

use App\Enums\ErrorEnum;
use App\Enums\ObtainingMethodEnum;
use App\Events\OrderCreated;
use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Dish;
use App\Models\ObtainingMethod;
use App\Models\ObtainingMethodOrder;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class OrderService
{

    public function storeOrderInfo(OrderRequest $request)
    {
        $data = $request->validated();
        $dishes = $data['dishes'];

        try {
            \DB::beginTransaction();

            $obtainingMethod = ObtainingMethod::query()->firstWhere('title', $data['obtainingMethod']);
            $order = $this->createOrder($data, $obtainingMethod);
            $address = $this->createAddress($data);
            $this->createObtainingMethodOrder($obtainingMethod, $order, $address);
            $this->addDishToOrder($dishes, $order);

            \DB::commit();

            OrderCreated::dispatch($order);

            return response([
                'success' => true,
                'orderId' => $order->id,
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();
            Log::critical($exception->getMessage());
            return response([
                'success' => false,
                'message' => ErrorEnum::UNKNOWN->value,
            ])->setStatusCode(500);
        }

    }

    private function calculateCost(array $dishes, ObtainingMethod $obtainingMethod): int|float
    {
        $sum = 0;
        foreach ($dishes as $dish) {
            $dishPrice = Dish::query()->firstWhere('id', $dish['id'])->price;
            $sum += $dishPrice * $dish['count'];
        }

        if ($obtainingMethod->title == ObtainingMethodEnum::DELIVERY->value) {
            $thresholdCost = Setting::query()->where('section', 'main')->where('key', 'Пороговая стоимость')->first()->value;
            $sum += $sum >= $thresholdCost ? 0 : $obtainingMethod->price;
        }

        return $sum;
    }

    private function createOrder(array $data, ObtainingMethod $obtainingMethod): Order
    {
        $customer = Customer::create($data);

        $paymentMethod = PaymentMethod::query()->firstWhere('title', $data['paymentMethod']);
        $receiptTime = "{$data['receiptDate']} с {$data['receiptTime']}";
        $dishes = $data['dishes'];

        return Order::create([
            'comment' => $data['comment'],
            'cost' => $this->calculateCost($dishes, $obtainingMethod),
            'receipt_time' => $receiptTime,
            'customer_id' => $customer->id,
            'payment_method_id' => $paymentMethod->id,
        ]);
    }

    private function createAddress(array $data): Address
    {
        return Address::create([
            'street' => $data['street'],
            'house' => $data['house'],
            'flat' => $data['flat'] ?? null,
            'entrance' => $data['entrance'] ?? null,
            'floor' => $data['floor'] ?? null,
            'intercom' => $data['intercom'] ?? null,
        ]);
    }

    private function createObtainingMethodOrder(ObtainingMethod $obtainingMethod, Order $order, Address $address): void
    {
        ObtainingMethodOrder::create([
            'obtaining_method_id' => $obtainingMethod->id,
            'order_id' => $order->id,
            'address_id' => $address->id,
        ]);
    }

    private function addDishToOrder(array $dishes, Order $order)
    {
        foreach ($dishes as $dish) {
            Cart::create([
                'order_id' => $order->id,
                'dish_id' => $dish['id'],
                'count' => $dish['count']
            ]);
        }
    }
}
