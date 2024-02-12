<?php

namespace App\Domain\Schedules\Models;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Lounges\Models\Lounge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ScheduleLounge
 *
 * @property int $id Идентификатор расписания лаунджа
 * @property string $date Дата расписания лаунджа
 * @property string $time_from Время начала расписания лаунджа
 * @property string $time_to Время окончания расписания лаунджа
 * @property int $lounge_id Идентификатор лаунджа
 *
 * @property Lounge $lounge Лаундж
 */
class ScheduleLounge extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time_from',
        'time_to',
        'lounge_id',
    ];

    public function lounge(): BelongsTo
    {
        return $this->belongsTo(Lounge::class);
    }

    public function booking(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_schedule_lounges');
    }
}
