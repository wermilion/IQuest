<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFilial extends EditRecord
{
    protected static string $resource = FilialResource::class;

    protected ?string $heading = 'Редактирование филиала';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление филиала'),
        ];
    }
}
