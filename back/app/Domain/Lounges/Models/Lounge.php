<?php

namespace App\Domain\Lounges\Models;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * Class Lounge
 *
 * @property int $id Идентификатор лаунджа
 * @property string $name Название лаунджа
 * @property string $description Описание лаунджа
 * @property string $cover Обложка лаунджа
 * @property int $max_people Максимальное количество людей
 * @property int $min_price Минимальная цена
 * @property bool $is_active Статус отображения
 * @property int $filial_id Идентификатор филиала
 *
 * @property Filial $filial Филиал
 */
class Lounge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover',
        'max_people',
        'min_price',
        'is_active',
        'filial_id',
    ];

    public function filial(): BelongsTo
    {
        return $this->belongsTo(Filial::class);
    }

    public function city(): HasOneThrough
    {
        return $this->hasOneThrough(
            City::class,
            Filial::class,
            'id',
            'id',
            'filial_id',
            'city_id'
        );
    }
}
