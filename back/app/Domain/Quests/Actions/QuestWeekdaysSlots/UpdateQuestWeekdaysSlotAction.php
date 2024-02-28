<?php

namespace App\Domain\Quests\Actions\QuestWeekdaysSlots;

use App\Domain\Quests\Models\QuestWeekdaysSlot;

class UpdateQuestWeekdaysSlotAction
{
    public function execute(QuestWeekdaysSlot $slot): void
    {
        $scheduleQuests = $slot->quest->scheduleQuests;
        $dirtyFields = array_keys($slot->getDirty());

        foreach ($dirtyFields as $field) {
            foreach ($scheduleQuests as $scheduleQuest) {
                $scheduleQuest->timeslots()
                    ->where($field, $slot->getOriginal($field))
                    ->update([
                        $field => $slot->$field,
                    ]);
            }
        }
    }
}
