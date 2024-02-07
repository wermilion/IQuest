<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Locations\Queries\RoomQuery;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\RoomResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoomController
{
    public function get(int $id, RoomQuery $query): RoomResource
    {
        return new RoomResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, RoomQuery $query): AnonymousResourceCollection
    {
        return RoomResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
