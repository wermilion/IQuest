<?php

namespace App\Domain\Locations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class City
 *
 * @property int $id - Идентификатор города
 * @property string $name - Название города
 *
 * @property Filial[] $filials
 */
class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'timezone',
    ];

    public function filials(): HasMany
    {
        return $this->hasMany(Filial::class);
    }
}
