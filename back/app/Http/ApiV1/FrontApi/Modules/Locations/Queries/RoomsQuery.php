<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Queries;

use App\Domain\Locations\Models\Room;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RoomsQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Room::query());

        $this->allowedIncludes([
            'filial'
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('city', 'filial.city.name'),
            AllowedFilter::exact('filial', 'filial.address'),
        ]);

        $this->defaultSort('id');
    }
}
