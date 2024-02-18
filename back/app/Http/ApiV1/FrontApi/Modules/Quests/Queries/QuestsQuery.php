<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Queries;

use App\Domain\Quests\Models\Quest;
use App\Domain\Quests\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class QuestsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Quest::query());

        $this->allowedIncludes([
            'scheduleQuests',
            'room.filial',
            'type',
            'genre',
            'level',
            'age_limit',
            'images'
        ]);

        $this->allowedFilters([
        ]);

        $this->allowedSorts([
            'sequence_number',
        ]);

        $this->defaultSort('sequence_number');
    }
}
