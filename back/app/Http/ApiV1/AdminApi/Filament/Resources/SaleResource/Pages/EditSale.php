<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    protected ?string $heading = 'Редактирование акции';

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->url(static::getResource()::getUrl());
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->modalHeading('Удалить акцию'),
        ];
    }
}
