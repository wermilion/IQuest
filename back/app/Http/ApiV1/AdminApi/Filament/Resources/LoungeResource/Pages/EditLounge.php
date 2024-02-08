<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource;
use App\Models\Lounge;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLounge extends EditRecord
{
    protected static string $resource = LoungeResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lounge = Lounge::query()->with(['filial', 'filial.city'])->find($data['id']);

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
