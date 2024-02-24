<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAgeLimit extends EditRecord
{
    protected static string $resource = AgeLimitResource::class;

    protected ?string $heading = 'Редактирование возрастного ограничения';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление возрастного ограничения'),
        ];
    }
}
