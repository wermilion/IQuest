<?php

namespace App\Http\ApiV1\FrontApi\Modules\Sales\Resources;

use App\Domain\Sales\Models\Sale;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Sale
 */
class SalesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->header,
            'description' => $this->description,
            'front_image' => $this->front_image,
            'back_image' => $this->back_image,
        ];
    }
}
