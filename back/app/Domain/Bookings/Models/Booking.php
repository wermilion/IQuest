<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Schedules\Models\ScheduleLounge;
use App\Domain\Schedules\Models\ScheduleQuest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Booking
 *
 * @property int $id Идентификатор бронирования
 * @property string $name Имя клиента
 * @property string $phone Номер телефона клиента
 * @property string $email Электронная почта клиента
 * @property BookingType $type Тип бронирования
 * @property BookingStatus $status Статус бронирования
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'type',
        'status',
    ];

    protected $casts = [
        'type' => BookingType::class,
        'status' => BookingStatus::class,
    ];

    protected static function booted(): void
    {
        static::updated(function (self $model) {
            if ($model->isDirty('status') && $model->status->value == BookingStatus::CANCELLED->value) {
                if ($model->type->value == BookingType::QUEST->value) {
                    $model->scheduleQuests()->update(['activity_status' => true]);
                }

                $model->delete();
            }
        });

        static::deleting(function (self $model) {
            if ($model->scheduleQuests()->exists()) {
                $model->scheduleQuests()->update(['activity_status' => true]);
            }
            if ($model->scheduleLounges()->exists()) {
                $model->scheduleLounges()->delete();
            }
        });
    }

    public function scheduleQuests(): BelongsToMany
    {
        return $this->belongsToMany(ScheduleQuest::class, 'booking_schedule_quests')
            ->withPivot(['count_participants', 'final_price', 'comment']);
    }

    public function scheduleLounges(): BelongsToMany
    {
        return $this->belongsToMany(ScheduleLounge::class, 'booking_schedule_lounges');
    }
}
