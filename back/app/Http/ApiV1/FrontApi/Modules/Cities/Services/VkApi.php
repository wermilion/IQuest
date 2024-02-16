<?php

namespace App\Http\ApiV1\FrontApi\Modules\Cities\Services;

use App\Domain\Cities\Data\SendVkDataRequest;
use App\Domain\Cities\Data\SendVkDataResponse;
use Exception;
use http\Client;

class VkApi
{
    public function __construct(Client $client)
    {
    }

    public function send(array $request)
    {
        return $this->client->send($request);
    }

    public function sendRequest(SendVkDataRequest $request): SendVkDataResponse
    {
        try {
            return new SendVkDataResponse($this->send($request->toArray()));
        } catch (Exception $e) {
            return null;
        }
    }
}
