<?php

namespace App\Domain\Schedules\Models;

use App\Domain\Quests\Models\Quest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ScheduleQuest
 *
 * @property int $id Идентификатор расписания квеста
 * @property string $date Дата расписания квеста
 * @property string $time Время расписания квеста
 * @property bool $activity_status Статус активности
 * @property int $quest_id Идентификатор квеста
 *
 * @property Quest $quest Квест
 */
class ScheduleQuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'activity_status',
        'quest_id'
    ];

    protected $casts = [
        'activity_status' => 'boolean'
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
