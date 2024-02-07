<?php

namespace App\Http\ApiV1\FrontApi\Modules\Locations\Resources;

use App\Domain\Locations\Models\Filial;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Filial
 */
class FilialResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'city' => new CityResource($this->whenLoaded('city')),
        ];
    }
}
