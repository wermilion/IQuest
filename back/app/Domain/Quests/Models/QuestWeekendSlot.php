<?php

namespace App\Domain\Quests\Models;

use App\Domain\Quests\Actions\QuestWeekendSlots\UpdateQuestWeekendSlot;
use App\Domain\Quests\Actions\QuestWeekendSlots\DeleteQuestWeekendSlot;
use App\Domain\Quests\Actions\QuestWeekendSlots\CreateQuestWeekendSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class QuestWeekendSlot
 *
 * @property int $id - Идентификатор
 * @property int $quest_id - Идентификатор квеста
 * @property string $time - Время
 * @property float $price - Цена
 *
 * @property-read Quest $quest
 */
class QuestWeekendSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'quest_id',
        'time',
        'price',
    ];

    protected static function booted(): void
    {
        static::created(function (self $model) {
            resolve(CreateQuestWeekendSlot::class)->execute($model);
        });

        static::updating(function (self $model) {
            resolve(UpdateQuestWeekendSlot::class)->execute($model);
        });

        static::deleted(function (self $model) {
            resolve(DeleteQuestWeekendSlot::class)->execute($model);
        });
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
