<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificateType extends CreateRecord
{
    protected static string $resource = CertificateTypeResource::class;

    protected ?string $heading = 'Создание сертификата';
}
