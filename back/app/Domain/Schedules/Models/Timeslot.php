<?php

namespace App\Domain\Schedules\Models;

use App\Domain\Bookings\Models\Booking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Timeslot
 *
 * @property int $id Идентификатор слота
 * @property string $time Время
 * @property float $price Цена
 * @property bool $is_active Статус активности
 *
 * @property ScheduleQuest $scheduleQuest Дата расписания квеста
 * @property Booking $booking Бронирование
 */
class Timeslot extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'price',
        'is_active',
        'schedule_quest_id',
    ];

    public function scheduleQuest(): BelongsTo
    {
        return $this->belongsTo(ScheduleQuest::class);
    }

    public function booking(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_schedule_quests')
            ->withPivot(['count_participants', 'final_price', 'comment']);
    }
}
