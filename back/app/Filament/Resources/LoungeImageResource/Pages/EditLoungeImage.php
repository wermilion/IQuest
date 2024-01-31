<?php

namespace App\Filament\Resources\LoungeImageResource\Pages;

use App\Filament\Resources\LoungeImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoungeImage extends EditRecord
{
    protected static string $resource = LoungeImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
