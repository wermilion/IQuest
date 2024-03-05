<?php

namespace App\Console\Commands;

use App\Domain\Quests\Models\Quest;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Domain\Schedules\Models\Timeslot;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleQuestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:schedule-quest {cityId} {timezone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create schedule for quests every day';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $timezone = $this->argument('timezone');
        $quests = Quest::whereHas('filial.city', fn($query) => $query->where('timezone', $timezone));
        $currentDate = Carbon::today($timezone);

        $this->deleteSlotsForYesterday($currentDate);

        if ($currentDate->isWeekday()) {
            $this->createScheduleQuests($quests, $currentDate, 'questWeekdaysSlots');
        } else {
            $this->createScheduleQuests($quests, $currentDate, 'questWeekendSlots');
        }
    }

    private function deleteSlotsForYesterday(Carbon $currentDate): void
    {
        $scheduleQuest = ScheduleQuest::whereDate('date', $currentDate->subDay())->first()->id;

        Timeslot::where('schedule_quest_id', $scheduleQuest)
            ->whereDoesntHave('booking')
            ->delete();
    }

    private function createScheduleQuests($quests, $currentDate, $slotType): void
    {
        $quests->each(function ($quest) use ($currentDate, $slotType) {
            $scheduleQuest = $quest->scheduleQuests()->create([
                'date' => $currentDate,
                'quest_id' => $quest->id,
            ]);

            $quest->$slotType->each(function ($slot) use ($scheduleQuest) {
                $scheduleQuest->timeslots()->create([
                    'time' => $slot->time,
                    'price' => $slot->price,
                    'is_active' => true,
                    'schedule_quest_id' => $scheduleQuest->id,
                ]);
            });
        });
    }
}
