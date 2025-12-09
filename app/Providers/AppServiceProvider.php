<?php

namespace App\Providers;

use App\Services\SiteConfig;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        /** @var SiteConfig $config */
        $config = $this->app->make(SiteConfig::class);

        View::share($config->sharedViewData());
    }
}
