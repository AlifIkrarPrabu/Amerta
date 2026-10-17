<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Memberitahu Laravel bahwa folder public berada di public_html
        $this->app->bind('path.public', function() {
            return base_path('../public_html');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Memberitahu Vite lokasi file manifest di public_html
        Vite::useManifestFilename('manifest.json');

        // Memaksa penggunaan HTTPS (SSL) saat berada di mode production/hosting
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
