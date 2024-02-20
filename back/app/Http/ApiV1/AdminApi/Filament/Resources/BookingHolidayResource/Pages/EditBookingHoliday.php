<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages;

use App\Domain\Holidays\Models\HolidayPackage;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingHoliday extends EditRecord
{
    protected static string $resource = BookingHolidayResource::class;

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
            Actions\DeleteAction::make(),
        ];
    }
}
