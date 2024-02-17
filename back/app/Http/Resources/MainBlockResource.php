<?php

namespace App\Http\Resources;

use App\Enums\ErrorEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class MainBlockResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request)
    {
        try {
            return ['data' => $this->getImages()];
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            return response([
                'success' => false,
                'message' => ErrorEnum::UNKNOWN->value,
            ]);
        }
    }

    private function getImages(): array
    {
        $imageCollection = $this->getMedia('mainBlock')->sortBy('order_column');

        $imageArray = [];
        foreach ($imageCollection as $image) {
            $imageArray[$image->order_column] = $image->getUrl();
        }
        return $imageArray;
    }
}
