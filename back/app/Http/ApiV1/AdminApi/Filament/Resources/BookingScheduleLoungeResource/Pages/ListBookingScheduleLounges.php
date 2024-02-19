<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingScheduleLounges extends ListRecords
{
    protected static string $resource = BookingScheduleLoungeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
