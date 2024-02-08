<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Queries;

use App\Domain\Quests\Models\Quest;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class QuestQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Quest::query());

        $this->allowedIncludes([
            'filial',
            'type',
            'genre',
            'level',
            'age_limit',
            'images'
        ]);

        $this->allowedFilters([
            AllowedFilter::callback('is_active', fn(Builder $query, $value) => $query->where('is_active', $value)),
        ]);

        $this->allowedSorts([
            'sequence_number',
        ]);

        $this->defaultSort('sequence_number');
    }
}
