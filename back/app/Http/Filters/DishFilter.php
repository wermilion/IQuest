<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class DishFilter extends AbstractFilter
{
    public const SUBCATEGORY_ID = 'subcategory';
    public const SUGAR = 'sugar';
    public const LACTOSE = 'lactose';
    public const GLUTEN = 'gluten';

    protected function getCallbacks(): array
    {
        return [
            self::SUBCATEGORY_ID => [$this, 'subcategoryId'],
            self::SUGAR => [$this, 'sugar'],
            self::LACTOSE => [$this, 'lactose'],
            self::GLUTEN => [$this, 'gluten'],
            ];
    }

    public function subcategoryId(Builder $builder, $value): void
    {
        $builder->where('subcategory_id', $value);
    }

    public function sugar(Builder $builder, $value): void
    {
        $builder->where('sugar', $value);
    }

    public function lactose(Builder $builder, $value): void
    {
        $builder->where('lactose', $value);
    }

    public function gluten(Builder $builder, $value): void
    {
        $builder->where('gluten', $value);
    }
}
