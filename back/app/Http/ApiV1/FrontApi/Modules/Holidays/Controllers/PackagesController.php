<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers;

use App\Domain\Holidays\Models\Holiday;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Queries\PackagesQuery;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Resources\PackagesResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PackagesController
{
    public function get(int $id, PackagesQuery $query): PackagesResource
    {
        return new PackagesResource($query->findOrFail($id));
    }

    public function search(Holiday $holiday, PageBuilderFactory $pageBuilderFactory, PackagesQuery $query): AnonymousResourceCollection
    {
        return PackagesResource::collectPage(
            $pageBuilderFactory->fromQuery($query
                ->join('holiday_packages', 'holiday_packages.package_id', '=', 'packages.id')
                ->where('is_active', true)
                ->where('holiday_packages.holiday_id', $holiday->id))
                ->build()
        );
    }
}
