<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Queries;

use App\Domain\Schedules\Models\ScheduleQuest;
use Carbon\Carbon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ScheduleQuestsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(ScheduleQuest::query());

        $this->allowedIncludes([
            'timeslots'
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('quest', "quest_id"),
            AllowedFilter::callback('today', fn($query, $value) => $query
                ->when($value, fn($query) => $query->whereDate('date', Carbon::today()))),
            AllowedFilter::callback('tomorrow', fn($query, $value) => $query
                ->when($value, fn($query) => $query->whereDate('date', Carbon::tomorrow()))),
            AllowedFilter::callback('weekend', function ($query, $value) {
                $sunday = Carbon::now()->endOfWeek();
                $saturday = $sunday->copy()->subDay();

                if (Carbon::today()->isWeekend()) {
                    $query->when($value, fn($query) => $query->whereIn('date', [$saturday->addWeek(), $sunday->addWeek()]));
                } else {
                    $query->when($value, fn($query) => $query->whereIn('date', [$saturday, $sunday]));
                }
            }),
            AllowedFilter::callback('between', function ($query, $value) {
                $query->whereBetween('date', $value);
            })
        ]);

        $this->defaultSorts([
            'date',
        ]);
    }
}
