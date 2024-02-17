<?php

namespace App\Http\Controllers\Api;

use App\Enums\ErrorEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            return CategoryResource::collection(Category::query()->orderBy('id')->get());
        } catch (\Exception $exception) {
            Log::critical($exception->getMessage());
            return response([
                'success' => false,
                'message' => ErrorEnum::UNKNOWN->value,
            ])->setStatusCode(500);
        }
    }
}
