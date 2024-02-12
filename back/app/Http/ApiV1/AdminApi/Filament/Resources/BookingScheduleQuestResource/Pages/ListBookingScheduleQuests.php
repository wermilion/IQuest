<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingQuestResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingScheduleQuests extends ListRecords
{
    protected static string $resource = BookingScheduleQuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
