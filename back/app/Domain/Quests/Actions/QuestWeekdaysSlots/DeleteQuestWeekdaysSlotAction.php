<?php

namespace App\Domain\Quests\Actions\QuestWeekdaysSlots;

use App\Domain\Quests\Models\QuestWeekdaysSlot;

class DeleteQuestWeekdaysSlotAction
{
    public function execute(QuestWeekdaysSlot $slot): void
    {
        $scheduleQuests = $slot->quest->scheduleQuests;

        foreach ($scheduleQuests as $scheduleQuest) {
            $scheduleQuest->timeslots()
                ->where('time', $slot->time)
                ->where('price', $slot->price)
                ->whereDoesntHave('booking')
                ->delete();
        }
    }
}
