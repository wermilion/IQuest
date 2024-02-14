<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Queries;

use App\Domain\Holidays\Models\Holiday;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class HolidaysQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Holiday::query());

        $this->allowedIncludes([
            'packages',
        ]);

        $this->allowedFilters([
            AllowedFilter::callback('packages.is_active', fn($query, $value) => $query->where('packages.is_active', $value)),
        ]);

        $this->defaultSort('id');
    }
}
