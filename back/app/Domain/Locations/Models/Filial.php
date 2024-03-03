<?php

namespace App\Domain\Locations\Models;

use App\Domain\Users\Models\FilialUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Filial
 *
 * @property int $id - Идентификатор филиала
 * @property string $address - Адрес филиала
 * @property string $yandex_mark - Яндекс метка
 * @property int $city_id - Идентификатор города
 *
 * @property City $city
 * @property-read FilialUser $filialUser
 */
class Filial extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'yandex_mark',
        'city_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
