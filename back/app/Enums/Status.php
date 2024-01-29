<?php

namespace App\Enums;

enum Status: string
{
    case New = 'Новый';
    case OnHold = 'На ожидании';
    case Approved = 'Подтвержденный';
    case Cancelled = 'Отмененный';
}
