<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages;

use App\Domain\Locations\Models\Filial;
use App\Http\ApiV1\AdminApi\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Редактирование пользователя';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $filial = Filial::query()->with('city')->find($data['filial_id']);

        $data['city'] = $filial?->city->id;

        return $data;
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->url(static::getResource()::getUrl());
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('change-password')
                ->label('Сменить пароль')
                ->modalHeading('Смена пароля')
                ->form([
                    TextInput::make('password')
                        ->autofocus()
                        ->label('Новый пароль')
                        ->password()
                        ->same('password_confirmation')
                        ->required()
                        ->revealable()
                        ->validationMessages([
                            'required' => 'Поле ":attribute" обязательное.',
                            'same' => 'Пароли должны совпадать',
                        ]),
                    TextInput::make('password_confirmation')
                        ->label('Подтверждение пароля')
                        ->password()
                        ->revealable()
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    $record->update([
                        'password' => Hash::make($data['password']),
                    ]);
                    Notification::make()
                        ->title('Пароль успешно изменен')
                        ->success()
                        ->send();
                }),
            Actions\DeleteAction::make()->modalHeading('Удаление пользователя'),
        ];
    }
}
