<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Resources;

use App\Domain\Quests\Models\Quest;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\RoomResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Quest
 */
class QuestResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'cover' => $this->cover,
            'min_price' => $this->min_price,
            'late_price' => $this->late_price,
            'min_people' => $this->min_people,
            'max_people' => $this->max_people,
            'duration' => $this->duration,
            'can_add_time' => $this->can_add_time,
            'is_active' => $this->is_active,
            'sequence_number' => $this->sequence_number,
            'weekdays' => $this->weekdays,
            'weekend' => $this->weekend,

            'room' => new RoomResource($this->whenLoaded('room')),
            'type' => new TypeResource($this->whenLoaded('type')),
            'genre' => new GenreResource($this->whenLoaded('genre')),
            'level' => new LevelResource($this->whenLoaded('level')),
            'age_limit' => new AgeLimitResource($this->whenLoaded('age_limit')),
            'images' => QuestImageResource::collection($this->whenLoaded('images'))
        ];
    }
}
