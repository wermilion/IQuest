<?php

namespace App\Http\Resources;

use App\Services\DishServices;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
{
    private DishServices $service;
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->service = app()->make(DishServices::class);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'calories' => $this->calorie,
            'proteins' => $this->getValue($this->proteins, 'г'),
            'fats' => $this->getValue($this->fats, 'г'),
            'carbohydrates' => $this->getValue($this->carbohydrates, 'г'),
            'desc' => $this->composition,
            'sugar' => $this->sugar,
            'lactose' => $this->lactose,
            'gluten' => $this->gluten,
            'weight' => $this->getValue($this->metric_value, $this->metric?->title),
            'img' => $this->getFirstMediaUrl('dishes'),
            'isAvailabel' => $this->service->checkAvailable($this->id),
        ];
    }

    public function getValue($value, $suffix): ?string
    {
        if (is_null($value)) {
            return null;
        }
        return "{$value} {$suffix}";
    }
}
