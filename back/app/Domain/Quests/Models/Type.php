<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type
 *
 * @property int $id - Идентификатор типа
 * @property string $name - Название типа
 */
class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
