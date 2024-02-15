<?php

namespace App\Domain\Quests\Models;

use App\Domain\Schedules\Models\ScheduleQuest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
        static::created(function (self $slot) {
            $currentDate = Carbon::now();
            $i = 0;
            while ($i < 30) {
                if ($currentDate->isWeekend()) {
                    ScheduleQuest::create([
                        'date' => $currentDate->format('Y-m-d'),
                        'time' => $slot->time,
                        'price' => $slot->price,
                        'activity_status' => true,
                        'quest_id' => $slot->quest_id,
                    ]);
                }
                $currentDate = $currentDate->addDay();
                $i++;
            }
        });

        static::updated(function (self $slot) {
            if ($slot->isDirty('time')) {
                ScheduleQuest::query()
                    ->where('quest_id', $slot->quest_id)
                    ->where('time', $slot->time)
                    ->update([
                        'time' => $slot->time
                    ]);
            }
            if ($slot->isDirty('price')) {
                ScheduleQuest::query()
                    ->where('quest_id', $slot->quest_id)
                    ->where('time', $slot->time)
                    ->update([
                        'price' => $slot->price
                    ]);
            }
        });

        static::deleted(function (self $slot) {
            ScheduleQuest::query()
                ->where('quest_id', $slot->quest_id)
                ->where('time', $slot->time)
                ->where('price', $slot->price)
                ->delete();
        });
    }

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }
}
