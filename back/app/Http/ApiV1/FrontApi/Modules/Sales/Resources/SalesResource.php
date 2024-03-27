<?php

namespace App\Http\ApiV1\FrontApi\Modules\Sales\Resources;

use App\Domain\Sales\Models\Sale;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;
use Illuminate\Support\Facades\Storage;

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
            'front_image' => Storage::disk('sales')->url($this->front_image),
            'back_image' => Storage::disk('sales')->url($this->back_image),
        ];
    }
}
