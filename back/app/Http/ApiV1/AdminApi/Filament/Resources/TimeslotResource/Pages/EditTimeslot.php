<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\Pages;

use App\Domain\Schedules\Models\ScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource;
use Filament\Resources\Pages\EditRecord;

class EditTimeslot extends EditRecord
{
    protected static string $resource = TimeslotResource::class;

    protected ?string $heading = 'Редактирование слота';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $scheduleQuest = ScheduleQuest::query()
            ->with(['quest', 'quest.room', 'quest.room.filial', 'quest.room.filial.city'])
            ->find($data['schedule_quest_id']);

        $data['date'] = $scheduleQuest->date;
        $data['quest'] = $scheduleQuest->quest->id;
        $data['room'] = $scheduleQuest->quest->room->id;
        $data['filial'] = $scheduleQuest->quest->room->filial->id;
        $data['city'] = $scheduleQuest->quest->room->filial->city->id;

        return $data;
    }
}
