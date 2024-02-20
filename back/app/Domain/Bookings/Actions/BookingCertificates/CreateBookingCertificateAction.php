<?php

namespace App\Domain\Bookings\Actions\BookingCertificates;

use App\Domain\Bookings\Models\BookingCertificate;

class CreateBookingCertificateAction
{
    public function execute(array $data): BookingCertificate
    {
        return BookingCertificate::create($data);
    }
}
