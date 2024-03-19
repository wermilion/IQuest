<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Queries;

use App\Domain\Quests\Models\Quest;
use App\Domain\Schedules\Models\ScheduleQuest;
use Carbon\Carbon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class ScheduleQuestsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(ScheduleQuest::query());

        $this->allowedIncludes([
            AllowedInclude::callback('timeslots', function ($query) {
                $query->withoutTrashed();
            }),
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('quest_id', 'quest_id'),
            AllowedFilter::callback('today', function ($query, $value) {
                $query->when($value, fn($query) => $query->whereDate('date', Carbon::today($this->getCityTimezone())));
            }),
            AllowedFilter::callback('tomorrow', function ($query, $value) {
                $query->when($value, fn($query) => $query->whereDate('date', Carbon::tomorrow($this->getCityTimezone())));
            }),
            AllowedFilter::callback('weekend', function ($query, $value) {
                $sunday = Carbon::now()->endOfWeek();
                $saturday = $sunday->copy()->subDay();
                $query->when($value, fn($query) => $query->whereIn('date', [$saturday, $sunday]));
            }),
            AllowedFilter::callback('between', function ($query, $value) {
                $query->whereBetween('date', $value);
            }),
        ]);

        $this->defaultSorts([
            'date',
        ]);
    }

    private function getCityTimezone()
    {
        $questId = request()->input('filter.quest_id');
        if (!$questId) {
            return null;
        }

        $quest = Quest::with('filial.city')->find($questId);

        return $quest->filial->city->timezone ?? null;
    }
}
