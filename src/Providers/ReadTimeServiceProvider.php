<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Providers;

use Illuminate\Support\ServiceProvider;
use Leshkens\LaravelReadTime\ReadTime;

/**
 * Class ReadTimeServiceProvider
 *
 * @package Leshkens\LaravelReadTime\Providers
 */
class ReadTimeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__
                . '/../../config/config.php' => config_path('read-time.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'read-time');

        // Register the main class to use with the facade
        $this->app->singleton('read-time', function () {
            return new ReadTime;
        });
    }
}
