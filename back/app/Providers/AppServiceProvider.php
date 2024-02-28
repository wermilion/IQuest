<?php

namespace App\Providers;

use App\Apis\VKApi;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup as FilamentNavigationGroup;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use VK\Client\VKApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme(config('app.force_https'));

        app()->bind(VKApi::class, function () {
            return new VKApi(
                new VKApiClient(),
                config('vk.vk_access_token'),
                config('vk.vk_group_id'),
            );
        });

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::BOOKING->value)
                    ->icon('heroicon-o-lock-closed'),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::SCHEDULE->value)
                    ->icon('heroicon-m-calendar-days'),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::QUEST_COMPONENTS->value)
                    ->icon('heroicon-o-inbox'),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::LOCATIONS->value)
                    ->icon('heroicon-o-building-office-2'),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::CONTACTS->value)
                    ->icon('heroicon-o-phone'),
            ]);
        });
    }
}
