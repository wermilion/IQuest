<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages;

use App\Domain\Holidays\Models\HolidayPackage;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookingHoliday extends CreateRecord
{
    protected static string $resource = BookingHolidayResource::class;

    protected ?string $heading = 'Создание заявки на праздник';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['holiday_package_id'] = HolidayPackage::query()
            ->where('holiday_id', $data['holiday'])
            ->where('package_id', $data['package'])
            ->firstOrFail()->id;

        unset($data['holiday'], $data['package']);

        return $data;
    }
}
