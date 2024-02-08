<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Queries;

use App\Domain\Locations\Models\Room;
use Spatie\QueryBuilder\QueryBuilder;

class RoomQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Room::query());

        $this->allowedIncludes([
            'filial'
        ]);

        $this->allowedFilters([
            'filial.address'
        ]);

        $this->defaultSort('id');
    }
}
