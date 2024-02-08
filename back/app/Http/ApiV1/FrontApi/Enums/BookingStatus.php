<?php

namespace App\Http\ApiV1\FrontApi\Enums;

use Filament\Support\Contracts\HasLabel;

enum BookingStatus: string implements HasLabel
{
    case NEW = 'Новая заявка';
    case APPROVED = 'Оплачено';
    case CANCELLED = 'Отменено';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
