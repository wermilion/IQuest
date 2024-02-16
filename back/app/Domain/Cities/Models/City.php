<?php

namespace App\Domain\Cities\Models;

use App\Domain\Cities\Enums\CityTypeEnum;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 *
 * @property int $id - Идентификатор города
 * @property string $name - Название города
 * @property CityTypeEnum $type - Тип города
 * @property int $responseCode - Код ответа
 * @property CarbonInterface $created_at - Дата создания
 * @property CarbonInterface $updated_at - Дата обновления
 */
class City extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $table = 'cities';

    protected $casts = [
        'type' => CityTypeEnum::class,
    ];
}
