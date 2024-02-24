<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Bookings\Actions\Bookings\SendMessageBookingAction;
use App\Domain\Schedules\Models\ScheduleQuest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BookingScheduleQuest
 *
 * @property int $id Идентификатор бронирования квеста
 * @property int $booking_id Идентификатор бронирования
 * @property int $schedule_quest_id Идентификатор расписания квеста
 * @property int $count_participants Количество участников
 * @property float $final_price Итоговая цена
 * @property string|null $comment Комментарий
 *
 * @property-read Booking $booking Бронирование
 * @property-read ScheduleQuest $scheduleQuest Расписание
 */
class BookingScheduleQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'schedule_quest_id',
        'count_participants',
        'final_price',
        'comment',
    ];

    protected static function booted(): void
    {
        static::created(function (self $model) {
            $model->scheduleQuest()->update(['is_active' => false]);
            resolve(SendMessageBookingAction::class)->execute($model->booking);
        });

        static::deleting(function (self $model) {
            $model->scheduleQuest()->update(['is_active' => true]);
            $model->booking()->delete();
        });
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class)->withTrashed();
    }

    public function scheduleQuest(): BelongsTo
    {
        return $this->belongsTo(ScheduleQuest::class);
    }
}
