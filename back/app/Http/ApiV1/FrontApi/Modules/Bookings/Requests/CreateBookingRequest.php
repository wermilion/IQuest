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
            'booking.name' => ['required', 'string'],
            'booking.phone' => ['required', 'string'],
            'booking.type' => ['required', new Enum(BookingType::class)],
            'booking.city_id' => ['required', 'integer', 'exists:cities,id'],

            'schedule_quest.timeslot_id' => ['nullable', 'integer', 'exists:timeslots,id'],
            'schedule_quest.count_participants' => ['nullable', 'integer', 'min:1'],
            'schedule_quest.final_price' => ['nullable', 'numeric', 'min:1'],
            'schedule_quest.comment' => ['nullable', 'string'],

            'holiday.holiday_id' => ['nullable', 'integer'],
            'holiday.package_id' => ['nullable', 'integer'],

            'certificate_type_id' => ['nullable', 'integer', 'exists:certificate_types,id'],
        ];
    }
}
