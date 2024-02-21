<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Schedules\Models\ScheduleQuest;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use VK\Client\VKApiClient;

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
            $model->scheduleQuest()->update(['activity_status' => false]);
            self::sendMessage($model);
        });

        static::deleting(function (self $model) {
            $model->scheduleQuest()->update(['activity_status' => true]);
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

    private static function sendMessage(self $model): void
    {
        $vk = new VKApiClient();

        $comment = $model->comment ? 'Комментарий: ' . $model->comment : '';
        $message = [
            'Новая заявка. Тип: ' . $model->booking->type->value,
            'Имя клиента: ' . $model->booking->name,
            'Телефон: ' . $model->booking->phone,
            'Квест: ' . $model->scheduleQuest->quest->slug,
            'Дата и время: ' . Carbon::parse($model->scheduleQuest->date)->translatedFormat('d.m.Y') . ' ' . $model->scheduleQuest->time,
            'Кол-во участников: ' . $model->count_participants,
            'Цена: ' . $model->final_price,
            $comment
        ];

        $userIds = User::query()
            ->whereNotNull('vk_id')
            ->whereIn('role', [Role::ADMIN->value, Role::OPERATOR->value])
            ->orWhere('filial_id', $model->scheduleQuest->quest->filial->id)
            ->where('role', Role::FILIAL_ADMIN->value)
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
