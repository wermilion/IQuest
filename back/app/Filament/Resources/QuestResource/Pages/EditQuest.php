<?php

namespace App\Filament\Resources\QuestResource\Pages;

use App\Filament\Resources\QuestResource;
use App\Models\Filial;
use App\Models\Room;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuest extends EditRecord
{
    protected static string $resource = QuestResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $room = Room::query()->with(['filial', 'filial.city'])->find($data['room_id']);

        $data['filial'] = $room?->filial->id;
        $data['city'] = $room?->filial->city->id;

        $data['weekdays'] = implode("\n", str_replace(',', "\n", $data['weekdays']));
        $data['weekend'] = implode("\n", str_replace(',', "\n", $data['weekend']));

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['weekdays'] = explode("\n", $data['weekdays']);
        $data['weekend'] = explode("\n", $data['weekend']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
