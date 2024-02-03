<?php

namespace App\Filament\Resources\QuestImageResource\Pages;

use App\Filament\Resources\QuestImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestImage extends EditRecord
{
    protected static string $resource = QuestImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
