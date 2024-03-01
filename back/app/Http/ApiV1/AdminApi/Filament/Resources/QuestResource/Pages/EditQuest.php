<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages;

use App\Domain\Locations\Models\Filial;
use App\Domain\Locations\Models\Room;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQuest extends EditRecord
{
    protected static string $resource = QuestResource::class;

    protected ?string $heading = 'Редактирование квеста';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $filial = Filial::query()->with(['city'])->find($data['filial_id']);

        $data['city'] = $filial?->city->id;

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
            DeleteAction::make()->modalHeading('Удаление квеста'),
        ];
    }
}
