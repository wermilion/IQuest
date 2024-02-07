<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LevelResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\LevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLevel extends EditRecord
{
    protected static string $resource = LevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
