<?php

/*
 * This file is part of Laravel Throttle.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Providers;

use App\Factories\CacheFactory;
use App\Factories\FactoryInterface;
use App\Transformers\TransformerFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;

/**
 * This is the throttle service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ThrottleServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../../config/throttle.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('throttle.php')]);
        }
        $this->mergeConfigFrom($source, 'throttle');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerTransformer();
        $this->registerThrottle();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('throttle.factory', function (Container $app) {
            $cache = $app->cache->driver($app->config->get('throttle.driver'));

            return new CacheFactory($cache);
        });

        $this->app->alias('throttle.factory', CacheFactory::class);
        $this->app->alias('throttle.factory', FactoryInterface::class);
    }

    /**
     * Register the transformer class.
     *
     * @return void
     */
    protected function registerTransformer()
    {
        $this->app->singleton('throttle.transformer', function () {
            return new TransformerFactory();
        });

        $this->app->alias('throttle.transformer', TransformerFactory::class);
    }

    /**
     * Register the throttle class.
     *
     * @return void
     */
    protected function registerThrottle()
    {
        $this->app->singleton('throttle', function (Container $app) {
            $factory = $app['throttle.factory'];
            $transformer = $app['throttle.transformer'];

            return new Throttle($factory, $transformer);
        });

        $this->app->alias('throttle', Throttle::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'throttle',
            'throttle.factory',
            'throttle.transformer',
        ];
    }
}
