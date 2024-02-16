<?php

namespace App\Http\ApiV1\FrontApi\Modules\Cities\Resources;

use App\Domain\Cities\Models\City;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;
use App\Http\ApiV1\Modules\Cities\Resources\StreetsCollection;
use App\Http\ApiV1\Modules\Orders\Resources\DeliveriesResource;

/**
 * @mixin City
 */
class CitiesResource extends BaseJsonResource
{
    public static $wrap = null;
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'streets' => StreetsCollection::collection($this->whenLoaded('streets')),
        ];
    }}
