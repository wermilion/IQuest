<?php

namespace App\Http\ApiV1\FrontApi\Modules\Quests\Resources;

use App\Domain\Quests\Models\QuestImage;
use App\Http\ApiV1\FrontApi\Support\Resources\BaseJsonResource;
use Storage;

/**
 * @mixin QuestImage
 */
class QuestImagesResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            'image' => $this->image ? Storage::url($this->image) : null,
        ];
    }
}
