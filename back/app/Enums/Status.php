<?php

namespace App\Enums;

enum Status: string
{
    case NEW = 'Новый';
    case ON_HOLD = 'На ожидании';
    case APPROVED = 'Подтвержденный';
    case CANCELLED = 'Отмененный';
}
