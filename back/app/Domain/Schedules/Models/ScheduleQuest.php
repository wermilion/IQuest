<?php

namespace App\Domain\Schedules\Models;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Quests\Models\Quest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ScheduleQuest
 *
 * @property int $id Идентификатор расписания квеста
 * @property string $date Дата расписания квеста
 * @property int $quest_id Идентификатор квеста
 *
 * @property Quest $quest Квест
 * @property HasMany $timeslots Временные слоты
 * @property Booking $booking Бронирование
 */
class ScheduleQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'quest_id'
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }

    public function timeslots(): HasMany
    {
        return $this->hasMany(Timeslot::class);
    }

    public function booking(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_schedule_quests')
            ->withPivot(['count_participants', 'final_price', 'comment']);
    }
}
