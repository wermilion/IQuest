<?php

namespace App\Filament\Resources\MainBlockResource\Pages;

use App\Enums\TargetEnums;
use App\Filament\Resources\MainBlockResource;
use App\Models\Block;
use App\Models\Target;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMainBlock extends CreateRecord
{
    protected static string $resource = MainBlockResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeCreate(): void
    {
        $target = Target::query()->firstWhere('title', TargetEnums::MAIN->value);
        $count = Block::query()->where('target_id', $target->id)->count();

        if ($count > 0) {
            Notification::make()
                ->warning()
                ->title('Ошибка')
                ->body('Запись уже существует')
                ->seconds(5)
                ->send();
            $this->halt();
        }
    }
}
