<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Создание пользователя';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
