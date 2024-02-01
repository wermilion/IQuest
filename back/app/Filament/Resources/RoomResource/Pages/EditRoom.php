<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use App\Models\City;
use App\Models\Filial;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use function Laravel\Prompts\select;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $city = Filial::query()->where('id', $data['filial_id'])->first()->city;
        $data['city'] = $city->id;
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
