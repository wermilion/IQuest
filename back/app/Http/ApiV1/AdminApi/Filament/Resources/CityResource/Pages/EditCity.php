<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCity extends EditRecord
{
    protected static string $resource = CityResource::class;

    protected ?string $heading = 'Редактирование города';

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->url(static::getResource()::getUrl());
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление города'),
        ];
    }
}
