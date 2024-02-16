<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Resources;

use App\Domain\Locations\Models\Room;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Room
 */
class RoomsResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'filial' => new FilialsResource($this->whenLoaded('filial')),
        ];
    }
}
