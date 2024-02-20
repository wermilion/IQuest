<?php

namespace App\Domain\Holidays\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Package
 *
 * @property int $id Идентификатор пакета
 * @property string $name Название пакета
 * @property string $description Описание пакета
 * @property float $price Цена пакета
 * @property int $min_people Минимальное количество людей
 * @property int $max_people Максимальное количество людей
 * @property bool $is_active Статус отображения
 * @property int $sequence_number Порядковый номер пакета
 *
 * @property-read Holiday[] $holidays
 * @property-read HolidayPackage[] $holidayPackages
 */
class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'min_people',
        'max_people',
        'is_active',
        'sequence_number',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function holidays(): BelongsToMany
    {
        return $this->belongsToMany(Holiday::class, 'holiday_packages');
    }

    public function holidayPackages(): HasMany
    {
        return $this->hasMany(HolidayPackage::class);
    }
}
