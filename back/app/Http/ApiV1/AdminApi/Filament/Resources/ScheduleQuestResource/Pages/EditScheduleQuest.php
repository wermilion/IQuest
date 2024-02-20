<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource\Pages;

use App\Domain\Quests\Models\Quest;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleQuestResource;
use Filament\Resources\Pages\EditRecord;

class EditScheduleQuest extends EditRecord
{
    protected static string $resource = ScheduleQuestResource::class;

    protected ?string $heading = 'Редактирование слота';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $quest = Quest::query()->with(['room', 'room.filial', 'room.filial.city'])->find($data['quest_id']);

        $data['room'] = $quest->room->id;
        $data['filial'] = $quest->room->filial->id;
        $data['city'] = $quest->room->filial->city->id;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
