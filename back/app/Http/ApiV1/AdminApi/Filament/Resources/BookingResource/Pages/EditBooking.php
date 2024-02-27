<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected ?string $heading = 'Редактирование заявки';

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->url(static::getResource()::getUrl());
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление заявки'),
        ];
    }
}
