<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages;

use App\Domain\Locations\Models\Room;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource;
use Filament\Resources\Pages\ViewRecord;

class ViewQuest extends ViewRecord
{
    protected static string $resource = QuestResource::class;

    protected ?string $heading = 'Просмотр квеста';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $room = Room::query()->with(['filial', 'filial.city'])->find($data['room_id']);

        $data['filial'] = $room?->filial->id;
        $data['city'] = $room?->filial->city->id;

        return $data;
    }
}
