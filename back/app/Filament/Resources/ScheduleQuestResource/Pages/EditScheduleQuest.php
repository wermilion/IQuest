<?php

namespace App\Filament\Resources\ScheduleQuestResource\Pages;

use App\Filament\Resources\ScheduleQuestResource;
use App\Models\Quest;
use App\Models\Room;
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
