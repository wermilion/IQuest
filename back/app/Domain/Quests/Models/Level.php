<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Level
 *
 * @property int $id - Идентификатор уровня сложности
 * @property string $name - Название уровня сложности
 */
class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
