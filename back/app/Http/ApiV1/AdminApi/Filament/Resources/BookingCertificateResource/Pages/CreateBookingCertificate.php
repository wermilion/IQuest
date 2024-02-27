<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookingCertificate extends CreateRecord
{
    protected static string $resource = BookingCertificateResource::class;

    protected ?string $heading = 'Создание заявки на сертификат';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
