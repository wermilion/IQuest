<?php

namespace App\Domain\Patients\Enums;

enum PatientTypeEnum: string
{
    case CAT = 'cat';
    case DOG = 'dog';
    case RABBIT = 'rabbit';
}
