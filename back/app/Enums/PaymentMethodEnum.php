<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CARD = 'Картой';
    case CASH = 'Наличный';
}
