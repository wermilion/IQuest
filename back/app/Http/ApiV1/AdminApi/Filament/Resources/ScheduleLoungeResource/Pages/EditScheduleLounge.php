<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages;

use App\Domain\Lounges\Models\Lounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditScheduleLounge extends EditRecord
{
    protected static string $resource = ScheduleLoungeResource::class;

    protected ?string $heading = 'Редактирование слота';

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
            DeleteAction::make()->modalHeading('Удаление слота'),
        ];
    }
}
