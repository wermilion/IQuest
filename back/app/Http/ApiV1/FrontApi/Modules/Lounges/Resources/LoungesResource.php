<?php

namespace App\Http\ApiV1\FrontApi\Modules\Lounges\Resources;

use App\Domain\Lounges\Models\Lounge;
use App\Http\ApiV1\FrontApi\Modules\Locations\Resources\FilialsResource;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Lounge
 */
class LoungesResource extends BaseJsonResource
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
            'filial' => new FilialsResource($this->whenLoaded('filial')),
        ];
    }
}
