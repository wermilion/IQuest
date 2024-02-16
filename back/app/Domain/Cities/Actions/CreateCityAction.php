<?php

namespace App\Domain\Cities\Actions;

use App\Domain\Cities\Models\City;

class CreateCityAction
{
    public function __construct(private readonly SendDataToVkAction $sendDataToVkAction)
    {
    }

    public function execute(array $data): City
    {
        $city = City::create($data);

        $this->sendDataToVkAction->execute($city);

        return $city;
    }
}
