<?php

namespace App\Filament\Resources\ScheduleLoungeResource\Pages;

use App\Filament\Resources\ScheduleLoungeResource;
use App\Models\Lounge;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScheduleLounge extends EditRecord
{
    protected static string $resource = ScheduleLoungeResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lounge = Lounge::query()->with(['filial', 'filial.city'])->find($data['lounge_id']);

        $data['filial'] = $lounge?->filial->id;
        $data['city'] = $lounge?->filial->city->id;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
