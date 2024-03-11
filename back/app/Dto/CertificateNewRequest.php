<?php

namespace App\Dto;

use Illuminate\Support\Fluent;

class CertificateNewRequest extends Fluent
{
    public function __construct(array $attributes = [])
    {
        $attributes['new_request'] = "Новая заявка: {$attributes['new_request']}";
        $attributes['certificate'] = "Тип сертификата: {$attributes['certificate']}";
        $attributes['customer_name'] = "Имя клиента: {$attributes['customer_name']}";
        $attributes['customer_phone'] = "Телефон: {$attributes['customer_phone']}";

        parent::__construct($attributes);
    }
}
