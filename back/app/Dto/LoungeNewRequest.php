<?php

namespace App\Dto;

use Illuminate\Support\Fluent;

class LoungeNewRequest extends Fluent
{
    public function __construct(array $attributes = [])
    {
        $attributes['new_request'] = "Новая заявка: {$attributes['new_request']}";
        $attributes['lounge'] = "Комната: {$attributes['lounge']}";
        $attributes['date_and_time'] = "Дата и время: {$attributes['date_and_time']}";
        $attributes['customer_name'] = "Имя клиента: {$attributes['customer_name']}";
        $attributes['customer_phone'] = "Телефон: {$attributes['customer_phone']}";

        parent::__construct($attributes);
    }
}
