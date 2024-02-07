<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Locations\Queries\FilialQuery;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\FilialResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FilialController
{
    public function get(int $id, FilialQuery $query): FilialResource
    {
        return new FilialResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, FilialQuery $query): AnonymousResourceCollection
    {
        return FilialResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
