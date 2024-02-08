<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Queries;

use App\Domain\Holidays\Models\Package;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PackageQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Package::query());

        $this->allowedFilters([
            AllowedFilter::callback('is_active', fn($query, $value) => $query->where('is_active', $value)),
        ]);
    }
}
