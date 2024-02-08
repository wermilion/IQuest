<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Holidays\Queries\HolidayQuery;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Resources\HolidayResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HolidayController
{
    public function get(int $id, HolidayQuery $query): HolidayResource
    {
        return new HolidayResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, HolidayQuery $query): AnonymousResourceCollection
    {
        return HolidayResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
