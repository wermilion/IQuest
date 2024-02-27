<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;

    protected ?string $heading = 'Создание города';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
