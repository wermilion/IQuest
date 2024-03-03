<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource;
use Filament\Actions\DeleteAction;

class EditCertificateType extends BaseEditRecord
{
    protected static string $resource = CertificateTypeResource::class;

    protected ?string $heading = 'Редактирование сертификата';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление сертификата'),
        ];
    }
}
