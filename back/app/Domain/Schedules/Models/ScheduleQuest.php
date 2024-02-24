<?php

namespace App\Domain\Schedules\Models;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Quests\Models\Quest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ScheduleQuest
 *
 * @property int $id Идентификатор расписания квеста
 * @property string $date Дата расписания квеста
 * @property string $time Время расписания квеста
 * @property float $price Цена
 * @property bool $is_active Статус активности
 * @property int $quest_id Идентификатор квеста
 *
 * @property Quest $quest Квест
 * @property Booking $booking Бронирование
 */
class ScheduleQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'price',
        'is_active',
        'quest_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }

    public function booking(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_schedule_quests')
            ->withPivot(['count_participants', 'final_price', 'comment']);
    }
}
