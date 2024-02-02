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
        $filial_id = Room::query()->where('id', $data['room_id'])->first()->filial_id;
        $city_id = Filial::query()->where('id', $filial_id)->first()->city_id;

        $data['filial'] = $filial_id;
        $data['city'] = $city_id;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
