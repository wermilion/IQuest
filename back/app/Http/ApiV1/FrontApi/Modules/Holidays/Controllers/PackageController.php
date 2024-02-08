<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Holidays\Queries\PackageQuery;
use App\Http\ApiV1\FrontApi\Modules\Holidays\Resources\PackageResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;

class PackageController
{
    public function get(int $id, PackageQuery $query): PackageResource
    {
        return new PackageResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, PackageQuery $query): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PackageResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
