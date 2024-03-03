<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource;
use Filament\Actions\DeleteAction;

class EditCity extends BaseEditRecord
{
    protected static string $resource = CityResource::class;

    protected ?string $heading = 'Редактирование города';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление города'),
        ];
    }
}
