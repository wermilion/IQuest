<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Locations\Queries\RoomsQuery;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\RoomsResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoomsController
{
    public function get(int $id, RoomsQuery $query): RoomsResource
    {
        return new RoomsResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, RoomsQuery $query): AnonymousResourceCollection
    {
        return RoomsResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
