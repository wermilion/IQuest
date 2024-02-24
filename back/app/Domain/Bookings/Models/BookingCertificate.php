<?php

namespace App\Domain\Bookings\Models;

use App\Domain\Bookings\Actions\Bookings\SendMessageBookingAction;
use App\Domain\Certificates\Models\CertificateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            resolve(SendMessageBookingAction::class)->execute($model->booking);
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
}
