<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource;

class CreateBookingCertificate extends BaseCreateRecord
{
    protected static string $resource = BookingCertificateResource::class;

    protected ?string $heading = 'Прикрепление заявки на сертификат';
}
