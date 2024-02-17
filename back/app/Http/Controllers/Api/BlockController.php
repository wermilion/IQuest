<?php

namespace App\Http\Controllers\Api;

use App\Enums\ErrorEnum;
use App\Enums\TargetEnums;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainBlockResource;
use App\Models\Block;
use App\Models\Target;
use Illuminate\Support\Facades\Log;

class BlockController extends Controller
{
    public function mainBlock()
    {
        try {
            $target = Target::query()->firstWhere('title', TargetEnums::MAIN->value);
            $mainBlock = Block::query()->firstWhere('target_id', $target->id);
            return new MainBlockResource($mainBlock);
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            return response([
                'success' => false,
                'message' => ErrorEnum::UNKNOWN->value,
            ])->setStatusCode(500);
        }
    }
}
