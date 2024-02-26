<?php

namespace App\Domain\Quests\Actions\QuestWeekendSlots;

use App\Domain\Quests\Models\QuestWeekendSlot;

class DeleteQuestWeekendSlot
{
    public function execute(QuestWeekendSlot $slot): void
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
