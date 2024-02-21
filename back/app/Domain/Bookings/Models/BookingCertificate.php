<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Certificates\Models\CertificateType;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use VK\Client\VKApiClient;

/**
 * Class BookingCertificate
 *
 * @property int $id Идентификатор заявки на сертификата
 * @property int $booking_id Идентификатор бронирования
 * @property int $certificate_type_id Идентификатор типа сертификата
 *
 * @property-read Booking $booking
 * @property-read CertificateType $certificateType
 */
class BookingCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'certificate_type_id',
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

    public function certificateType(): BelongsTo
    {
        return $this->belongsTo(CertificateType::class);
    }

    private static function sendMessage(self $model): void
    {
        $vk = new VKApiClient();

        $message = [
            'Новая заявка. Тип: ' . $model->booking->type->value,
            'Имя клиента: ' . $model->booking->name,
            'Телефон: ' . $model->booking->phone,
            'Тип сертификата: ' . $model->certificateType->name,
            'Цена сертификата: ' . $model->certificateType->price,
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
