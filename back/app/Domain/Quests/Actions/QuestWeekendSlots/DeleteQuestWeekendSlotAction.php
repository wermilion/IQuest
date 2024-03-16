<?php

namespace App\Domain\Quests\Actions\QuestWeekendSlots;

use App\Domain\Quests\Models\QuestWeekendSlot;
use App\Domain\Schedules\Models\ScheduleQuest;

class DeleteQuestWeekendSlotAction
{
    public function execute(QuestWeekendSlot $slot): void
    {
        $scheduleQuests = $slot->quest->scheduleQuests;

        $scheduleQuests->each(function (ScheduleQuest $scheduleQuest) use ($slot) {
            $timeslot = $scheduleQuest->timeslots
                ->where('time', $slot->time)
                ->where('price', $slot->price)
                ->first();

            if ($timeslot->bookingScheduleQuest()->doesntExist()) {
                $timeslot->forceDelete();
            } else {
                $timeslot->delete();
            }
        });
    }
}
