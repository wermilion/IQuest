<?php

namespace App\Domain\Holidays\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class HolidayPackage
 *
 * @property int $id Идентификатор пакета праздника
 * @property int $holiday_id Идентификатор праздника
 * @property int $package_id Идентификатор пакета
 *
 * @property-read Holiday $holiday Праздник
 * @property-read Package $package Пакет
 */
class HolidayPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'holiday_id',
        'package_id',
    ];

    public function holiday(): BelongsTo
    {
        return $this->belongsTo(Holiday::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
