<?php

namespace App\Http\ApiV1\FrontApi\Modules\Lounges\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Lounges\Queries\LoungeQuery;
use App\Http\ApiV1\FrontApi\Modules\Lounges\Resources\LoungeResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LoungeController
{
    public function get(int $id, LoungeQuery $query): LoungeResource
    {
        return new LoungeResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, LoungeQuery $query): AnonymousResourceCollection
    {
        return LoungeResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
