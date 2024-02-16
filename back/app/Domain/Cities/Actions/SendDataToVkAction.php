<?php

namespace App\Domain\Cities\Actions;

use App\Domain\Cities\Data\SendVkDataRequest;
use App\Domain\Cities\Models\City;
use App\Http\ApiV1\FrontApi\Modules\Cities\Services\VkApi;

class SendDataToVkAction
{
    public function __construct(private readonly VkApi $vkApi)
    {
    }

    public function execute(City $city)
    {
        $request = new SendVkDataRequest();
        $request->request_id = 123;

        $response = $this->vkApi->sendRequest($request);
        if ($response->errorMessage !== null) {
            $city->responseCode = 0;
        }
    }
}
