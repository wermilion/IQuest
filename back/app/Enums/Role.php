<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case OPERATOR = 'operator';
    case FILIAL_ADMIN = 'filial_admin';
}
