<?php

namespace App\Enums;

enum NavigationGroupEnum: string
{
    case DISHES = 'Блюда';
    case CONTACT_INFORMATION = 'Контактная информация';
    case BLOCKS = 'Блоки главной страницы';
    case SETTINGS = 'Настройки';
}
