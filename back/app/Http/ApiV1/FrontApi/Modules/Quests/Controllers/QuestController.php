<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Quests\Queries\QuestQuery;
use App\Http\ApiV1\FrontApi\Modules\Quests\Resources\QuestResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestController
{

    public function get(int $id, QuestQuery $query): QuestResource
    {
        return new QuestResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, QuestQuery $query): AnonymousResourceCollection
    {
        return QuestResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
