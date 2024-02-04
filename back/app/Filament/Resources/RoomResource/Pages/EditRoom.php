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
        $filial = Filial::query()->with('city')->find($data['filial_id']);

        $data['city'] = $filial?->city->id;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
