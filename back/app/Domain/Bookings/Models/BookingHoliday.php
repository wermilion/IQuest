<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Holidays\Models\HolidayPackage;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use VK\Client\VKApiClient;

/**
 * Class BookingHoliday
 *
 * @property int $id Идентификатор заявки на праздник
 * @property int $booking_id Идентификатор бронирования
 * @property int $holiday_package_id Идентификатор пакета праздника
 * @property string|null $comment Комментарий
 *
 * @property-read Booking $booking Бронирование
 * @property-read HolidayPackage $holidayPackage Пакет праздника
 */
class BookingHoliday extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'holiday_package_id',
        'comment',
    ];

    protected static function booted(): void
    {
        static::created(function (self $model) {
            self::sendMessage($model);
        });

        static::deleting(function (self $model) {
            $model->booking()->delete();
        });
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class)->withTrashed();
    }

    public function holidayPackage(): BelongsTo
    {
        return $this->belongsTo(HolidayPackage::class);
    }

    private static function sendMessage(self $model): void
    {
        $vk = new VKApiClient();

        $message = [
            'Новая заявка. Тип: ' . $model->booking->type->value,
            'Имя клиента: ' . $model->booking->name,
            'Телефон: ' . $model->booking->phone,
            'Тип праздника: ' . $model->holidayPackage->holiday->type->value,
            'Пакет: ' . $model->holidayPackage->package->name,
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
