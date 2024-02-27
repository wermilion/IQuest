<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Genre
 *
 * @property int $id - Идентификатор жанра
 * @property string $name - Название жанра
 */
class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
