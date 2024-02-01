<?php

namespace App\Filament\Resources\LoungeResource\Pages;

use App\Filament\Resources\LoungeResource;
use App\Models\Filial;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLounge extends EditRecord
{
    protected static string $resource = LoungeResource::class;

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
