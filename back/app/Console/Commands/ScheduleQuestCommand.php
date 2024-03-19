<?php

namespace App\Console\Commands;

use App\Domain\Quests\Models\Quest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

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
        $currentDate = Carbon::now($timezone);

        $this->deleteSlotsForYesterday($quests, $currentDate);

        $currentDate->addDays(PERIOD_OF_DAYS);

        if ($currentDate->isWeekday()) {
            $this->createScheduleQuests($quests, $currentDate, 'questWeekdaysSlots');
        } else {
            $this->createScheduleQuests($quests, $currentDate, 'questWeekendSlots');
        }
    }

    private function deleteSlotsForYesterday(Builder $quests, Carbon $currentDate): void
    {
        $quests->each(function ($quest) use ($currentDate) {
            $scheduleQuest = $quest->scheduleQuests()->whereDate('date', $currentDate->copy()->subDay())->first();

            $scheduleQuest->timeslots()
                ->whereDoesntHave('bookingScheduleQuest')
                ->forceDelete();
            $scheduleQuest->timeslots()
                ->whereHas('bookingScheduleQuest')
                ->delete();

            if ($scheduleQuest->timeslots()->doesntExist()) {
                $scheduleQuest->forceDelete();
            }
        });
    }

    private function createScheduleQuests(Builder $quests, Carbon $currentDate, $slotType): void
    {
        $quests->each(function ($quest) use ($currentDate, $slotType) {
            $scheduleQuest = $quest->scheduleQuests()->firstOrCreate([
                'date' => $currentDate,
                'quest_id' => $quest->id,
            ]);

            $quest->$slotType->each(function ($slot) use ($scheduleQuest) {
                $scheduleQuest->timeslots()->firstOrCreate([
                    'time' => $slot->time,
                    'price' => $slot->price,
                    'is_active' => true,
                    'schedule_quest_id' => $scheduleQuest->id,
                ]);
            });
        });
    }
}
