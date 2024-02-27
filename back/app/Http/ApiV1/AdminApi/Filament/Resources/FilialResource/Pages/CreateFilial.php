<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFilial extends CreateRecord
{
    protected static string $resource = FilialResource::class;

    protected ?string $heading = 'Создание филиала';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
