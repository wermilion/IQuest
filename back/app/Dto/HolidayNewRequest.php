<?php

namespace App\Dto;

use Illuminate\Support\Fluent;

class HolidayNewRequest extends Fluent
{
    public function __construct(array $attributes = [])
    {
        $attributes['new_request'] = "Новая заявка: {$attributes['new_request']}";
        $attributes['holiday_and_package'] = "Праздник и пакет: {$attributes['holiday_and_package']}";
        $attributes['customer_name'] = "Имя клиента: {$attributes['customer_name']}";
        $attributes['customer_phone'] = "Телефон: {$attributes['customer_phone']}";

        parent::__construct($attributes);
    }
}
