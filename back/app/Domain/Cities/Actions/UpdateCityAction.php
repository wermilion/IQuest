<?php

namespace App\Domain\Cities\Actions;

use App\Domain\Cities\Models\City;

class UpdateCityAction
{
    public function __construct(private readonly SendDataToVkAction $sendDataToVkAction)
    {
    }

    public function execute(int $id, array $data): City
    {
        $city = City::firstOrFail()->update($data);

        $this->sendDataToVkAction->execute($city);

        return $city;
    }
}
