<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateType extends CreateRecord
{
    protected static string $resource = TypeResource::class;

    protected ?string $heading = 'Создание типа';
}
