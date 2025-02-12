<?php

namespace Sburina\Whmcs;

use Illuminate\Support\ServiceProvider;

/**
 * Whmcs ServiceProvider.
 */
class WhmcsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->isLaravel()) {
            $source = dirname(__DIR__) . '/config/whmcs.php';
            $this->mergeConfigFrom($source, 'whmcs');
            $this->publishes([$source => $this->app->configPath('whmcs.php')]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerWhmcs();
    }

    /**
     * register Whmcs.
     */
    public function registerWhmcs()
    {
        $this->app->singleton('whmcs', function () {
            return new Whmcs();
        });
        $this->app->alias('whmcs', Whmcs::class);
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'whmcs',
        ];
    }

    /**
     * @return bool
     */
    protected function isLaravel()
    {
        return !preg_match('/lumen/i', $this->app->version());
    }
}

