<?php

namespace App\Http\ApiV1\FrontApi\Modules\Schedules\Resources;

use App\Domain\Schedules\Models\ScheduleQuest;
use App\Http\ApiV1\FrontApi\Modules\Quests\Resources\QuestsResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin ScheduleQuest
 */
class ScheduleQuestsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'time' => $this->time,
            'activity_status' => $this->activity_status,
            'quest' => new QuestsResource($this->whenLoaded('quest')),
        ];
    }
}
