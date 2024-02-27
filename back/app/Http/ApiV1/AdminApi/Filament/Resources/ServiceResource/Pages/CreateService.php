<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected ?string $heading = 'Создание услуги';
}
