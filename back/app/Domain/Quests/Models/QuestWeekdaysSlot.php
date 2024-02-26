<?php

namespace App\Domain\Quests\Models;

use App\Domain\Quests\Actions\QuestWeekendSlots\CreateQuestWeekdaysSlot;
use App\Domain\Quests\Actions\QuestWeekendSlots\DeleteQuestWeekdaysSlot;
use App\Domain\Quests\Actions\QuestWeekendSlots\UpdateQuestWeekdaysSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class QuestWeekdaysSlot
 *
 * @property int $id - Идентификатор
 * @property int $quest_id - Идентификатор квеста
 * @property string $time - Время
 * @property float $price - Цена
 *
 * @property-read Quest $quest
 */
class QuestWeekdaysSlot extends Model
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
            resolve(CreateQuestWeekdaysSlot::class)->execute($model);
        });

        static::updating(function (self $model) {
            resolve(UpdateQuestWeekdaysSlot::class)->execute($model);
        });

        static::deleted(function (self $model) {
            resolve(DeleteQuestWeekdaysSlot::class)->execute($model);
        });
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
