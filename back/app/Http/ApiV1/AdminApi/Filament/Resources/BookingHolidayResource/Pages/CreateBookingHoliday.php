<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Holidays\Models\HolidayPackage;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource;
use Illuminate\Database\Eloquent\Model;

class CreateBookingHoliday extends BaseCreateRecord
{
    protected static string $resource = BookingHolidayResource::class;

    protected ?string $heading = 'Создание заявки на праздник';

    protected function handleRecordCreation(array $data): Model
    {
        $saveData['booking_id'] = Booking::create($data['booking'][0])->id;
        $saveData['holiday_package_id'] = HolidayPackage::query()
            ->where('holiday_id', $data['holidayPackage'][0]['holiday'])
            ->where('package_id', $data['holidayPackage'][0]['package'])
            ->firstOrFail()
            ->id;
        unset($data['holidayPackage']);
        return parent::handleRecordCreation($saveData);
    }
}
