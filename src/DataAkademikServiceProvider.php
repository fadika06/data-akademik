<?php

namespace Bantenprov\DataAkademik;

use Illuminate\Support\ServiceProvider;
use Bantenprov\DataAkademik\Console\Commands\DataAkademikCommand;

/**
 * The DataAkademikServiceProvider class
 *
 * @package Bantenprov\DataAkademik
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class DataAkademikServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
        $this->seedHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('data-akademik', function ($app) {
            return new DataAkademik;
        });

        $this->app->singleton('command.data-akademik', function ($app) {
            return new DataAkademikCommand;
        });

        $this->commands('command.data-akademik');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'data-akademik',
            'command.data-akademik',
        ];
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle()
    {
        $packageConfigPath = __DIR__.'/config/config.php';
        $appConfigPath     = config_path('data-akademik.php');

        $this->mergeConfigFrom($packageConfigPath, 'data-akademik');

        $this->publishes([
            $packageConfigPath => $appConfigPath,
        ], 'data-akademik-config');
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle()
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'data-akademik');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/data-akademik'),
        ], 'data-akademik-lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'data-akademik');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/data-akademik'),
        ], 'data-akademik-views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle()
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], 'data-akademik-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'data-akademik-migrations');
    }

    public function publicHandle()
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], 'data-akademik-public');
    }

    public function seedHandle()
    {
        $packageSeedPath = __DIR__.'/database/seeds';

        $this->publishes([
            $packageSeedPath => base_path('database/seeds')
        ], 'data-akademik-seeds');
    }
}
