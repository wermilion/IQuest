<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Resources;

use App\Domain\Quests\Models\Quest;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\RoomsResource;
use App\Http\ApiV1\FrontApi\Modules\Schedules\Resources\ScheduleQuestsResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Quest
 */
class QuestsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'cover' => $this->cover,
            'min_people' => $this->min_people,
            'max_people' => $this->max_people,
            'duration' => $this->duration,
            'can_add_time' => $this->can_add_time,
            'is_active' => $this->is_active,
            'sequence_number' => $this->sequence_number,

            'scheduleQuests' => ScheduleQuestsResource::collection($this->whenLoaded('scheduleQuests')),
            'room' => new RoomsResource($this->whenLoaded('room')),
            'type' => new TypesResource($this->whenLoaded('type')),
            'genre' => new GenresResource($this->whenLoaded('genre')),
            'level' => new LevelsResource($this->whenLoaded('level')),
            'age_limit' => new AgeLimitsResource($this->whenLoaded('age_limit')),
            'images' => QuestImagesResource::collection($this->whenLoaded('images'))
        ];
    }
}
