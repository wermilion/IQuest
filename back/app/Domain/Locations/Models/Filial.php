<?php

namespace App\Domain\Locations\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Filial
 *
 * @property int $id - Идентификатор филиала
 * @property string $address - Адрес филиала
 * @property int $city_id - Идентификатор города
 *
 * @property City $city
 */
class Filial extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'city_id',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    protected function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
