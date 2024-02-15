<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Schedules\Models\ScheduleLounge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BookingScheduleLounge
 *
 * @property int $id Идентификатор бронирования лаунджа
 * @property int $booking_id Идентификатор бронирования
 * @property int $schedule_lounge_id Идентификатор расписания лаунджа
 *
 * @property-read Booking $booking Бронирование
 * @property-read ScheduleLounge $scheduleLounge Расписание
 */
class BookingScheduleLounge extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'schedule_lounge_id'
    ];

    protected static function booted(): void
    {
        static::deleted(function (self $model) {
            $model->scheduleLounge->delete();
            $model->booking->delete();
        });
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function scheduleLounge(): BelongsTo
    {
        return $this->belongsTo(ScheduleLounge::class);
    }
}
