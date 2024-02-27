<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages;

use App\Domain\Lounges\Models\Lounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLounge extends EditRecord
{
    protected static string $resource = LoungeResource::class;

    protected ?string $heading = 'Редактирование лаунжа';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $lounge = Lounge::query()->with(['filial', 'filial.city'])->find($data['id']);

        $data['city'] = $lounge?->filial->city->id;

        return $data;
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->url(static::getResource()::getUrl());
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление лаунжа'),
        ];
    }
}
