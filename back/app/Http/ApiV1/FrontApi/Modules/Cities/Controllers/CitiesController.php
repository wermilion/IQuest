<?php

namespace App\Http\ApiV1\FrontApi\Modules\Cities\Controllers;

use App\Domain\Cities\Actions\CreateCityAction;
use App\Domain\Cities\Actions\UpdateCityAction;
use App\Http\ApiV1\FrontApi\Modules\Cities\Queries\CitiesQuery;
use App\Http\ApiV1\FrontApi\Modules\Cities\Requests\CreateCityRequest;
use App\Http\ApiV1\FrontApi\Modules\Cities\Resources\CitiesResource;
use App\Http\ApiV1\FrontApi\Support\Pagination\PageBuilderFactory;
use App\Http\ApiV1\FrontApi\Support\Resources\EmptyResource;
use App\Http\ApiV1\Modules\Cities\Controllers\DeleteCityAction;
use App\Http\ApiV1\Modules\Cities\Controllers\UpdateCityRequest;

class CitiesController
{
    public function create(CreateCityRequest $request, CreateCityAction $action): CitiesResource
    {
        return new CitiesResource($action->execute($request->validated()));
    }

    public function get(int $id, CitiesQuery $query)
    {
        return new CitiesResource($query->findOrFail($id));
    }

    public function search(PageBuilderFactory $pageBuilderFactory, CitiesQuery $query)
    {
        return CitiesResource::collectPage(
            $pageBuilderFactory->fromQuery($query)->build()
        );
    }

    public function update(int $id, UpdateCityRequest $request, UpdateCityAction $action)
    {
        return new CitiesResource($action->execute($request->validated()));
    }

    public function delete(int $id, DeleteCityAction $action) {
        $action->execute($id);

        return new EmptyResource();
    }
}
