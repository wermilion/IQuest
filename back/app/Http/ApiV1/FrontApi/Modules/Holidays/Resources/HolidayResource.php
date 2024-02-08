<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Resources;

use App\Domain\Holidays\Models\Holiday;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Holiday
 */
class HolidayResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'packages' => PackageResource::collection($this->whenLoaded('packages')),
        ];
    }
}
