<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Locations\Queries\CityQuery;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\CityResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CityController
{
    public function get(int $id, CityQuery $query): CityResource
    {
        return new CityResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, CityQuery $query): AnonymousResourceCollection
    {
        return CityResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
