<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScheduleQuest extends EditRecord
{
    protected static string $resource = ScheduleQuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
