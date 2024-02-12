<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingQuestResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookingScheduleQuest extends CreateRecord
{
    protected static string $resource = BookingScheduleQuestResource::class;
}
