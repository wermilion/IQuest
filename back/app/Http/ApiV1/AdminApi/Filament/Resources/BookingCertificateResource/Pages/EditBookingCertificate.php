<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource;
use Filament\Actions\DeleteAction;

class EditBookingCertificate extends BaseEditRecord
{
    protected static string $resource = BookingCertificateResource::class;

    protected ?string $heading = 'Редактирование заявки на сертификат';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление заявки'),
        ];
    }
}
