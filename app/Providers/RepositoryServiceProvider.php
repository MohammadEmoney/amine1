<?php

namespace App\Providers;

use App\Repositories\SettingsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsRepository::class, function ($app) {
            return new SettingsRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $view->with('settings', app(SettingsRepository::class)->get()?->data);
            $view->with('logo', app(SettingsRepository::class)->get()?->getFirstMediaUrl('logo'));
            $view->with('favicon', app(SettingsRepository::class)->get()?->getFirstMediaUrl('favicon'));
        });
        view()->composer('livewire.front.pages.live-contact-us', function ($view) {
            $view->with('setting', app(SettingsRepository::class)->get()?->data['contact_us'] ?? null);
            $view->with('background', app(SettingsRepository::class)->get()?->getFirstMediaUrl('contact_us_bg'));
        });
        view()->composer('livewire.front.pages.live-cooperation', function ($view) {
            $view->with('setting', app(SettingsRepository::class)->get()?->data['cooperation'] ?? null);
            $view->with('background', app(SettingsRepository::class)->get()?->getFirstMediaUrl('cooperation_bg'));
        });
        view()->composer('livewire.front.pages.live-agency', function ($view) {
            $view->with('setting', app(SettingsRepository::class)->get()?->data['agency'] ?? null);
            $view->with('background', app(SettingsRepository::class)->get()?->getFirstMediaUrl('agency_bg'));
        });
    }
}
