<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LevelResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\LevelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLevel extends EditRecord
{
    protected static string $resource = LevelResource::class;

    protected ?string $heading = 'Редактирование уровня сложности';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление уровня сложности'),
        ];
    }
}
