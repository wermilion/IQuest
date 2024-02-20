<?php

namespace App\Domain\Bookings\Actions\Bookings;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Models\Booking;

class CreateBookingAction
{
    public function execute(array $data): Booking
    {
        return Booking::create([...$data, 'status' => BookingStatus::NEW->value]);
    }
}
