<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource;
use Filament\Actions\DeleteAction;

class EditAgeLimit extends BaseEditRecord
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
