<?php

namespace App\Providers;

use Filament\Facades\Filament;
use App\Services\SettingsService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Services\Parsers\BadgeParser;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class, function () {
            return new SettingsService();
        });

        $this->app->singleton(BadgeParser::class, function () {
            return new BadgeParser();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('fromClient', request()->has('fromClient'));
        View::share('availableLanguages', config('hotel.cms.available_languages'));

        if (App::isProduction() && config('hotel.force_https')) {
            URL::forceScheme('https');
        }

        $this->bootDashboardSettings();
    }

    /**
     * Bootstrap the dashboard settings.
     */
    private function bootDashboardSettings(): void
    {
        Filament::serving(function() {
            Filament::registerStyles([asset('assets/css/ckeditor.css')]);
            Filament::registerViteTheme('resources/scss/filament.scss');

            $getNavigationLabel = fn (string $label) => __("filament::resources.navigations.{$label}");

            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label($getNavigationLabel('Dashboard'))
                    ->collapsible(false)
                    ->icon('heroicon-s-server'),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Website'))
                    ->collapsed()
                    ->icon('heroicon-s-desktop-computer'),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Help Center'))
                    ->collapsed()
                    ->icon('heroicon-o-support'),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Hotel'))
                    ->collapsed()
                    ->icon('heroicon-s-office-building'),

                NavigationGroup::make()
                    ->label($getNavigationLabel('Administration'))
                    ->collapsed()
                    ->icon('heroicon-s-adjustments'),

                NavigationGroup::make()
                    ->label($getNavigationLabel('User Management'))
                    ->collapsed()
                    ->icon('heroicon-s-user'),
            ]);
        });
    }
}
