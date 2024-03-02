<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource;
use Filament\Actions\DeleteAction;

class EditService extends BaseEditRecord
{
    protected static string $resource = ServiceResource::class;

    protected ?string $heading = 'Редактирование услуги';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление услуги'),
        ];
    }
}
