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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $quest = Quest::query()->with(['room', 'room.filial', 'room.filial.city'])->findOrFail($data['quest_id']);

        $data['room'] = $quest->room->id;
        $data['filial'] = $quest->room->filial->id;
        $data['city'] = $quest->room->filial->city->id;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
