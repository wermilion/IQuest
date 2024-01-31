<?php

namespace App\Filament\Resources\LoungeResource\Pages;

use App\Filament\Resources\LoungeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLounge extends EditRecord
{
    protected static string $resource = LoungeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
