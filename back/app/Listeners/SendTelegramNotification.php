<?php

namespace App\Listeners;

use App\Enums\ObtainingMethodEnum;
use App\Events\OrderCreated;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Dish;
use App\Models\ObtainingMethod;
use App\Models\Order;
use App\Models\Setting;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendTelegramNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        Telegram::sendMessage([
            'chat_id' => '-1001633480225',
            'parse_mode' => 'HTML',
            'text' => $this->configureMessage($order),
        ]);
    }

    private function configureMessage(Order $order): string
    {
        $message = "
<b>Номер:</b> {$order->id}
<b>Дата и время получения:</b> {$order->receipt_time}\n
<b>Способ получения:</b> {$order->pivot->obtainingMethod->title}
<b>Способ оплаты:</b> {$order->paymentMethod->title}\n
<b>Личные данные клиента</b>
<b>ФИО:</b> {$order->customer->name}
<b>Номер телефона:</b> {$order->customer->phone}
<b>Почта:</b> {$this->getCustomerEmail($order->customer)}
<b>Комментарий:</b> {$this->getComment($order)}";

        $message .=  $order->pivot->obtainingMethod->title == ObtainingMethodEnum::DELIVERY->value ?
            "\n<b>Адрес доставки:</b> {$this->getAddress($order->pivot->address)}" : "";

        $message .= "\n\n<b>Заказ:</b>";

        $message .= "\n {$this->getDishes($order)}";

        $message .=  $order->pivot->obtainingMethod->title == ObtainingMethodEnum::DELIVERY->value ?
            "\n<b>Стоимость доставки:</b> {$this->getDeliveryPrice($order)} р." : "";

        $message .= "\n<b>Итого к оплате:</b> {$order->cost} р.";

        return $message;
    }

    private function getCustomerEmail(Customer $customer): string
    {
        return $customer->email ?? '-';
    }

    private function getComment(Order $order): string
    {
        return $order->comment ?? '-';
    }

    private function getAddress(Address $address): string
    {
        $addressString = "Ул. {$address->street}, д. {$address->house}";
        $addressString .= $address->flat ? ", кв. {$address->flat}" : "";
        $addressString .= $address->entrance ? ", п. {$address->entrance}" : "";
        $addressString .= $address->floor ? ", эт. {$address->floor}" : "";
        $addressString .= $address->intercom ? ", домофон {$address->intercom}" : "";

        return $addressString;
    }

    private function getDishes(Order $order,): string
    {
        $dishesList = "";
        $cart = $order->cart;
        foreach ($cart as $key => $position) {
            $dish = Dish::query()->find($position->dish_id);
            $order = $key + 1;
            $price = $position->count * $dish->price;
            $dishesList .= "{$order}. {$dish->title} - {$position->count} шт. - {$price} р.\n";
        }
        return $dishesList;
    }

    private function getDeliveryPrice(Order $order): int
    {
        $deliveryPrice = $order->pivot->obtainingMethod->price;
        $cart = $order->cart;
        $sum = 0;

        foreach ($cart as $key => $position) {
            $dish = Dish::query()->find($position->dish_id);
            $sum += $position->count * $dish->price;
        }

        $thresholdCost = Setting::query()->where('section', 'main')->where('key', 'Пороговая стоимость')->first()->value;

        return $sum >= $thresholdCost ? 0 : $deliveryPrice;
    }
}
