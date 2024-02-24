<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditType extends EditRecord
{
    protected static string $resource = TypeResource::class;

    protected ?string $heading = 'Редактирование типа';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление типа'),
        ];
    }
}
