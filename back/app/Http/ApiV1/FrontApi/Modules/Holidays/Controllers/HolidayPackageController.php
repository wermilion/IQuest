<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Holidays\Queries\HolidayPackageQuery;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Resources\HolidayPackageResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HolidayPackageController
{
    public function get(int $id, HolidayPackageQuery $query): HolidayPackageResource
    {
        return new HolidayPackageResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, HolidayPackageQuery $query): AnonymousResourceCollection
    {
        return HolidayPackageResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
