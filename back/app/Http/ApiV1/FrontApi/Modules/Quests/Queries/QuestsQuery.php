<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Queries;

use App\Domain\Quests\Models\Quest;
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
            AllowedFilter::exact('city', 'room.filial.city.name'),
        ]);

        $this->allowedSorts([
            AllowedSort::field('sequence_number'),
            AllowedSort::field('type', 'type_id'),
            AllowedSort::field('genre', 'genre_id'),
            AllowedSort::field('level', 'level_id'),
            AllowedSort::field('age_limit', 'age_limit_id'),
        ]);

        $this->defaultSort('sequence_number');
    }
}
