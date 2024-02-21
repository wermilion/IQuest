<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Schedules\Models\ScheduleLounge;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use VK\Client\VKApiClient;

/**
 * Class Booking
 *
 * @property int $id Идентификатор бронирования
 * @property string $name Имя клиента
 * @property string $phone Номер телефона клиента
 * @property string $email Электронная почта клиента
 * @property BookingType $type Тип бронирования
 * @property BookingStatus $status Статус бронирования
 *
 * @property-read  BookingScheduleQuest $bookingScheduleQuest
 * @property-read  BookingScheduleLounge $bookingScheduleLounge
 * @property-read  ScheduleQuest $scheduleQuests
 * @property-read  ScheduleLounge $scheduleLounges
 * @property-read  ScheduleLounge $scheduleLounge
 * @property-read  BookingHoliday $bookingHoliday
 * @property-read  BookingCertificate $bookingCertificate
 */
class Booking extends Model
{
    use HasFactory, SoftDeletes;

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
        static::created(function (self $model) {
            if ($model->type->value == BookingType::LOUNGE->value) {
                self::sendMessage($model);
            }
        });

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
                $model->bookingScheduleQuest()->delete();
            } else if ($model->bookingScheduleLounge()->exists()) {
                $model->bookingScheduleLounge()->delete();
            } else if ($model->bookingHoliday()->exists()) {
                $model->bookingHoliday()->delete();
            } else if ($model->bookingCertificate()->exists()) {
                $model->bookingCertificate()->delete();
            }
        });
    }

    public function bookingScheduleQuest(): HasOne
    {
        return $this->hasOne(BookingScheduleQuest::class)->withTrashed();
    }

    public function bookingScheduleLounge(): HasOne
    {
        return $this->hasOne(BookingScheduleLounge::class)->withTrashed();
    }

    public function bookingHoliday(): HasOne
    {
        return $this->hasOne(BookingHoliday::class)->withTrashed();
    }

    public function bookingCertificate(): HasOne
    {
        return $this->hasOne(BookingCertificate::class)->withTrashed();
    }

    public function scheduleQuests(): BelongsToMany
    {
        return $this->belongsToMany(ScheduleQuest::class, 'booking_schedule_quests')
            ->withPivot(['count_participants', 'final_price', 'comment']);
    }

    public function scheduleLounges(): BelongsToMany
    {
        return $this->belongsToMany(ScheduleLounge::class, 'booking_schedule_lounges')
            ->withPivot(['comment']);
    }

    private static function sendMessage(self $model): void
    {
        $vk = new VKApiClient();

        $message = [
            'Новая заявка. Тип: ' . $model->type->value,
            'Имя клиента: ' . $model->name,
            'Телефон: ' . $model->phone,
        ];

        $userIds = User::query()
            ->whereNotNull('vk_id')
            ->whereIn('role', [Role::ADMIN->value, Role::OPERATOR->value])
            ->pluck('vk_id')
            ->toArray();

        foreach ($userIds as $userId) {
            $isAllow = $vk->messages()->isMessagesFromGroupAllowed(env('VK_ACCESS_TOKEN'), [
                'group_id' => env('VK_GROUP_ID'),
                'user_id' => $userId,
            ]);

            if ($isAllow['is_allowed']) {
                $vk->messages()->send(env('VK_ACCESS_TOKEN'), [
                    'user_id' => $userId,
                    'random_id' => 0,
                    'message' => implode('<br>', $message),
                ]);
            }
        }
    }
}
