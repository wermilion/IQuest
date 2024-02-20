<?php

namespace App\Http\ApiV1\FrontApi\Modules\Holidays\Resources;

use App\Domain\Holidays\Models\Package;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;

/**
 * @mixin Package
 */
class PackagesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'min_people' => $this->min_people,
            'max_people' => $this->max_people,
            'price' => $this->price,
            'sequence_number' => $this->sequence_number,
        ];
    }
}
