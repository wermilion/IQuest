<?php

namespace App\Console\Commands;

use App\Domain\Locations\Models\City;
use App\Domain\Quests\Models\Quest;
use App\Domain\Schedules\Models\ScheduleQuest;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CreateScheduleQuests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:schedule-quests {city_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create schedule quests';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $city = City::query()->findOrFail($this->argument('city_id'));

            echo "Creating schedule quests for city: " . $city->name . "\n";

            $currentDate = Carbon::now(); // TODO: check timezone
            echo "Current date: " . $currentDate->format('Y-m-d') . "\n";

            $quests = Quest::query()
                ->with(['filial.city'])
                ->whereHas('room.filial.city', fn($query) => $query->where('id', $city->id))
                ->get();

            if (!$quests->count()) exit($this->error("No quests found for city: " . $city->name));

            echo "Quests count: " . $quests->count() . "\n";

            $i = 0;

            DB::transaction(function () use ($quests, $currentDate, &$i) {
                foreach ($quests as $quest) {
                    while ($i != 30) {                              // Создание записей на 30 дней вперед
                        if (is_weekend($currentDate)) {             // Проверка на день недели
                            foreach ($quest->weekend as $time) {
                                if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
                                    DB::rollBack();
                                    exit($this->error("Wrong time format: " . $time . " in quest: " . $quest->name));
                                }

                                ScheduleQuest::query()->create([
                                    'date' => $currentDate,
                                    'time' => $time,
                                    'activity_status' => true,
                                    'quest_id' => $quest->id,
                                ]);
                            }
                        } else {
                            foreach ($quest->weekdays as $time) {
                                if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
                                    DB::rollBack();
                                    exit($this->error("Wrong time format: " . $time . " in quest: " . $quest->name));
                                }

                                ScheduleQuest::query()->create([
                                    'date' => $currentDate,
                                    'time' => $time,
                                    'activity_status' => true,
                                    'quest_id' => $quest->id,
                                ]);
                            }
                        }
                        $currentDate = $currentDate->addDays();
                        echo "Next date: " . $currentDate->format('Y-m-d') . "\n";
                        $i++;
                    }
                }
            });
        } catch (ModelNotFoundException $e) {
            $this->error('City not found');
            exit;
        }
    }
}
