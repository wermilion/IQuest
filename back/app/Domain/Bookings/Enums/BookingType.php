<?php

namespace App\Domain\Bookings\Enums;

use Filament\Support\Contracts\HasLabel;

enum BookingType: string implements HasLabel
{
    case QUEST = 'Квест';
    case LOUNGE = 'Лаундж';
    case HOLIDAY = 'Праздник';
    case CERTIFICATE = 'Сертификат';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}