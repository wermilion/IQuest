<?php

namespace App\Http\ApiV1\FrontApi\Modules\Lounges\Resources;

use App\Domain\Lounges\Models\Lounge;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\FilialResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Lounge
 */
class LoungeResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'cover' => $this->cover,
            'max_people' => $this->max_people,
            'min_price' => $this->min_price,
            'is_active' => $this->is_active,
            'filial' => new FilialResource($this->whenLoaded('filial')),
        ];
    }
}
