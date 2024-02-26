<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Resources;

use App\Domain\Quests\Models\Quest;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\RoomsResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;
use Storage;

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
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'cover' => $this->cover ? Storage::url($this->cover) : null,
            'min_people' => $this->min_people,
            'max_people' => $this->max_people,
            'duration' => $this->duration,
            'level' => $this->level,

            'type' => new TypesResource($this->whenLoaded('type')),
            'genre' => new GenresResource($this->whenLoaded('genre')),
            'age_limit' => new AgeLimitsResource($this->whenLoaded('age_limit')),
            'images' => QuestImagesResource::collection($this->whenLoaded('images')),
            'room' => new RoomsResource($this->whenLoaded('room')),
        ];
    }
}
