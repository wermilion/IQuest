<?php

namespace App\Dto;

use Illuminate\Support\Fluent;

class QuestNewRequest extends Fluent
{
    public function __construct(array $attributes = [])
    {
        $attributes['new_request'] = "Новая заявка: {$attributes['new_request']}";
        $attributes['quest'] = "Квест: {$attributes['quest']}";
        $attributes['date_and_time'] = "Дата и время: {$attributes['date_and_time']}";
        $attributes['customer_name'] = "Имя клиента: {$attributes['customer_name']}";
        $attributes['customer_phone'] = "Телефон: {$attributes['customer_phone']}";
        $attributes['count_participants'] = "Кол - во участников: {$attributes['count_participants']}";
        $attributes['final_price'] = "Цена: {$attributes['final_price']}";

        parent::__construct($attributes);
    }
}
