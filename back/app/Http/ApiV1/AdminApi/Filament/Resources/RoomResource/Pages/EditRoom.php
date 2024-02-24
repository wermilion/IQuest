<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\RoomResource\Pages;

use App\Domain\Locations\Models\Filial;
use App\Http\ApiV1\AdminApi\Filament\Resources\RoomResource;
use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRoom extends EditRecord
{
    protected static string $resource = RoomResource::class;

    protected ?string $heading = 'Редактирование комнаты';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $filial = Filial::query()->with('city')->find($data['filial_id']);

        $data['city'] = $filial?->city->id;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление комнаты'),
        ];
    }
}
