<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Queries;

use App\Domain\Schedules\Models\ScheduleQuest;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ScheduleQuestsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(ScheduleQuest::query());

        $this->allowedIncludes([
            'quest',
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
        ]);

        $this->defaultSort('id');
    }
}
