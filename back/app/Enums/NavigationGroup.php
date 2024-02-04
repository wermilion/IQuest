<?php

namespace App\Enums;

enum NavigationGroup: string
{
    case SCHEDULE = 'Расписание';
    case LOCATIONS = 'Точки';
    case USERS = 'Пользователи';
    case QUEST_COMPONENTS = 'Компоненты квестов';
}
