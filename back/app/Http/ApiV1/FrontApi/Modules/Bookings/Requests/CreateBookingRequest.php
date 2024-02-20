<?php

namespace App\Http\ApiV1\FrontApi\Modules\Bookings\Requests;

use App\Domain\Bookings\Enums\BookingType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;


class CreateBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'type' => ['required', new Enum(BookingType::class)],
        ];
    }
}
