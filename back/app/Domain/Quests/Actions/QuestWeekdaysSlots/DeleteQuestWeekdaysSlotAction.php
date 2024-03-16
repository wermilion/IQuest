<?php

namespace App\Domain\Quests\Actions\QuestWeekdaysSlots;

use App\Domain\Quests\Models\QuestWeekdaysSlot;
use App\Domain\Schedules\Models\ScheduleQuest;

class DeleteQuestWeekdaysSlotAction
{
    public function execute(QuestWeekdaysSlot $slot): void
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
