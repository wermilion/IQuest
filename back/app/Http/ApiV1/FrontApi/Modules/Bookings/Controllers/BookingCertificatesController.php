<?php

namespace App\Http\ApiV1\FrontApi\Modules\Bookings\Controllers;

use App\Domain\Bookings\Actions\BookingCertificates\CreateBookingCertificateAction;
use App\Http\ApiV1\FrontApi\Modules\Bookings\Requests\CreateBookingRequest;
use App\Http\ApiV1\FrontApi\Modules\Bookings\Resources\BookingCertificatesResource;

class BookingCertificatesController
{
    public function create(CreateBookingRequest $request, CreateBookingCertificateAction $action): BookingCertificatesResource
    {
        return new BookingCertificatesResource($action->execute($request->validated()));
    }
}
