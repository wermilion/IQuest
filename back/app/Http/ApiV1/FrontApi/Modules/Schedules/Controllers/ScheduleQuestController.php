<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Controllers;

use App\Http\ApiV1\FrontApi\Modules\Schedules\Queries\ScheduleQuestQuery;
use App\Http\ApiV1\FrontApi\Modules\Schedules\Resources\ScheduleQuestResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ScheduleQuestController
{
    public function get(int $id, ScheduleQuestQuery $query): ScheduleQuestResource
    {
        return new ScheduleQuestResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, ScheduleQuestQuery $query): AnonymousResourceCollection
    {
        return ScheduleQuestResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }
}
