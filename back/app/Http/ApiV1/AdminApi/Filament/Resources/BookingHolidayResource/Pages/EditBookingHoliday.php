<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages;

use App\Domain\Holidays\Models\HolidayPackage;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookingHoliday extends EditRecord
{
    protected static string $resource = BookingHolidayResource::class;

    protected ?string $heading = 'Редактирование заявки на праздник';

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->url(static::getResource()::getUrl());
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $holiday = HolidayPackage::query()->find($data['holiday_package_id'])->holiday->id;
        $package = HolidayPackage::query()->find($data['holiday_package_id'])->package->id;

        $data['holiday'] = $holiday;
        $data['package'] = $package;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->modalHeading('Удаление заявки'),
        ];
    }
}
