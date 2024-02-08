<?php

namespace App\Domain\Holidays\Models;

use App\Http\ApiV1\FrontApi\Enums\HolidayType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Holiday
 *
 * @property int $id Идентификатор праздника
 * @property string $type Тип праздника
 *
 * @property-read HolidayPackage[] $holidayPackages
 * @property-read Package[] $packages
 */
class Holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    protected $casts = [
        'type' => HolidayType::class,
    ];

    public function holidayPackages(): HasMany
    {
        return $this->hasMany(HolidayPackage::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'holiday_packages');
    }
}
