<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    protected ?string $heading = 'Создание акции';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
