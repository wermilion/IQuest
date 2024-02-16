<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
