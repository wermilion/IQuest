<?php

namespace App\Http\ApiV1\FrontApi\Modules\Cities\Queries;

use App\Domain\Cities\Models\City;
use App\Domain\Orders\Models\Order;
use Ensi\QueryBuilderHelpers\Filters\DateFilter;
use Ensi\QueryBuilderHelpers\Filters\ExtraFilter;
use Ensi\QueryBuilderHelpers\Filters\NumericFilter;
use Ensi\QueryBuilderHelpers\Filters\StringFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CitiesQuery extends QueryBuilder
{
    public function __construct()
    {
        $query = City::query();

        parent::__construct($query);

        $this->allowedIncludes([
            'items',
            'deliveries',
            'deliveries.shipments',
            'deliveries.shipments.orderItems',
            'files',
        ]);

        $this->allowedSorts([
            'id',
            'number',
            'customer_email',
            'cost',
            'price',
            'spent_bonus',
            'added_bonus',
            'promo_code',
            'delivery_price',
            'delivery_cost',
            'receiver_name',
            'receiver_phone',
            'receiver_email',
            'status_at',
            'payment_status_at',
            'payed_at',
            'payment_expires_at',
            'is_expired',
            'is_expired_at',
            'is_return',
            'is_return_at',
            'is_partial_return',
            'is_partial_return_at',
            'is_problem',
            'is_problem_at',
            'created_at',
            'updated_at',
            'payment_external_id',
        ]);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            ...StringFilter::make('number')->exact()->contain(),
            AllowedFilter::exact('customer_id'),
            ...StringFilter::make('customer_email')->contain(),
            AllowedFilter::exact('status'),
            ...DateFilter::make('status_at')->gte()->lte(),

            AllowedFilter::exact('payment_status'),
            ...DateFilter::make('payment_status_at')->gte()->lte(),
            ...DateFilter::make('payed_at')->gte()->lte(),
            ...DateFilter::make('payment_expires_at')->gte()->lte(),
            ...StringFilter::make('payment_external_id')->contain(),

            AllowedFilter::exact('source'),
            AllowedFilter::exact('responsible_id'),
            AllowedFilter::exact('delivery_method'),
            AllowedFilter::exact('delivery_service'),
            AllowedFilter::exact('delivery_point_id'),
            AllowedFilter::exact('payment_method'),
            AllowedFilter::exact('payment_system'),
            AllowedFilter::exact('is_expired'),
            AllowedFilter::exact('is_return'),
            AllowedFilter::exact('is_partial_return'),
            AllowedFilter::exact('is_problem'),

            AllowedFilter::exact('deliveries.shipments.seller_id'),
            AllowedFilter::exact('deliveries.shipments.store_id'),

            ...ExtraFilter::nested('streets', [
                ...StringFilter::make('name')->contain(),
            ]),

            AllowedFilter::scope('manager_comment_like'),
            ...StringFilter::make('promo_code')->contain(),

            ...NumericFilter::make('cost')->gte()->lte(),
            ...NumericFilter::make('price')->gte()->lte(),
            ...NumericFilter::make('spent_bonus')->gte()->lte(),
            ...NumericFilter::make('added_bonus')->gte()->lte(),
            ...NumericFilter::make('delivery_price')->gte()->lte(),
            ...NumericFilter::make('delivery_cost')->gte()->lte(),

            ...StringFilter::make('receiver_name')->contain(),
            ...StringFilter::make('receiver_phone')->contain(),
            ...StringFilter::make('receiver_email')->contain(),

            ...DateFilter::make('is_expired_at')->gte()->lte(),
            ...DateFilter::make('is_return_at')->gte()->lte(),
            ...DateFilter::make('is_partial_return_at')->gte()->lte(),
            ...DateFilter::make('is_problem_at')->gte()->lte(),
            ...StringFilter::make('problem_comment')->contain(),
            ...StringFilter::make('delivery_comment')->contain(),
            ...StringFilter::make('client_comment')->contain(),
            ...DateFilter::make('created_at')->gte()->lte(),
            ...DateFilter::make('updated_at')->gte()->lte(),
        ]);

        $this->defaultSort('id');
    }
}
