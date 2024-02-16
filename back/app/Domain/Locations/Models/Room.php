<?php

namespace App\Domain\Locations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Room
 *
 * @property int $id - Идентификатор комнаты
 * @property string $name - Название комнаты
 * @property int $filial_id - Идентификатор филиала
 *
 * @property Filial $filial
 */
class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'filial_id'
    ];

    public function filial(): BelongsTo
    {
        return $this->belongsTo(Filial::class);
    }

}
