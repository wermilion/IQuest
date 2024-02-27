<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGenre extends CreateRecord
{
    protected static string $resource = GenreResource::class;

    protected ?string $heading = 'Создание жанра';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
