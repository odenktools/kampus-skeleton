<?php

namespace App\Providers;

use App\Models\Kampus;
use App\KampusApp;
use App\Repositories\EloquentKampusRepository;
use Illuminate\Support\ServiceProvider;

/**
 * KampusServiceProvider.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Providers
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class KampusServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->registerFacades();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'kampus',
            'kampus.repokampus',
            'kampus.facade',
        ];
    }

    /**
     * Register Core Kampus
     * Ini agar mempermudah programmer untuk menggunakannya
     * dikarenakan Method Seluruhnya berupa `Singleton`.
     *
     * @see \App\VouchersApp::__construct
     */
    protected function registerFacades()
    {
        $this->app->singleton('kampus.repokampus', function ($app) {
            return new EloquentKampusRepository($app, new Kampus());
        });

        $this->app->singleton('kampus.facade', function ($app) {
            return new KampusApp($app, $app['kampus.repokampus']);
        });
    }
}
