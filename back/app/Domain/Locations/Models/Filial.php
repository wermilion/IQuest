<?php

namespace App\Domain\Locations\Models;

use App\Domain\Lounges\Models\Lounge;
use App\Domain\Quests\Models\Quest;
use App\Domain\Users\Models\FilialUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Filial
 *
 * @property int $id - Идентификатор филиала
 * @property string $address - Адрес филиала
 * @property string $yandex_mark - Яндекс метка
 * @property int $city_id - Идентификатор города
 *
 * @property City $city
 * @property Quest $quests
 * @property Lounge $lounges
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

    public function quests(): HasMany
    {
        return $this->hasMany(Quest::class);
    }

    public function lounges(): HasMany
    {
        return $this->hasMany(Lounge::class);
    }
}
