<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingCertificate extends EditRecord
{
    protected static string $resource = BookingCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
