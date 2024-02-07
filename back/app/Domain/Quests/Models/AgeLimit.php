<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AgeLimit
 *
 * @property int $id - Идентификатор возрастного ограничения
 * @property int $limit = Возрастное ограничение
 */
class AgeLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'limit'
    ];
}
