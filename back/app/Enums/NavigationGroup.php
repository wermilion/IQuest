<?php

namespace App\Enums;

enum NavigationGroup: string
{
    case BOOKING = 'Бронирование';
    case SCHEDULE = 'Расписание';
    case QUEST_COMPONENTS = 'Компоненты квестов';
    case HOLIDAYS = 'Праздники';
    case LOCATIONS = 'Точки';
}
