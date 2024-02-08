<?php

namespace App\Domain\Quests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class QuestImage
 *
 * @property int $id - Идентификатор картинки
 * @property string $image - Путь к картинке
 * @property int $quest_id - Идентификатор квеста
 *
 * @property-read Quest $quest
 */
class QuestImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'quest_id'
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
