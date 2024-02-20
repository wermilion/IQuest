<?php

namespace App\Http\ApiV1\FrontApi\Modules\Bookings\Resources;

use App\Domain\Bookings\Models\BookingCertificate;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin  BookingCertificate
 */
class BookingCertificatesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'booking_id' => $this->booking_id,
            'certificate_type_id' => $this->certificate_type_id,
        ];
    }
}
