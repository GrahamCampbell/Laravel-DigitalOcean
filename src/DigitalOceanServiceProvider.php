<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean;

use DigitalOceanV2\DigitalOceanV2;
use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory as AdapterFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the digitalocean service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DigitalOceanServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function setupConfig(Application $app)
    {
        $source = realpath(__DIR__.'/../config/digitalocean.php');

        if ($app instanceof LaravelApplication && $app->runningInConsole()) {
            $this->publishes([$source => config_path('digitalocean.php')]);
        } elseif ($app instanceof LumenApplication) {
            $app->configure('digitalocean');
        }

        $this->mergeConfigFrom($source, 'digitalocean');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAdapterFactory($this->app);
        $this->registerDigitalOceanFactory($this->app);
        $this->registerManager($this->app);
        $this->registerBindings($this->app);
    }

    /**
     * Register the adapter factory class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerAdapterFactory(Application $app)
    {
        $app->singleton('digitalocean.adapterfactory', function ($app) {
            return new AdapterFactory();
        });

        $app->alias('digitalocean.adapterfactory', AdapterFactory::class);
    }

    /**
     * Register the digitalocean factory class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerDigitalOceanFactory(Application $app)
    {
        $app->singleton('digitalocean.factory', function ($app) {
            $adapter = $app['digitalocean.adapterfactory'];

            return new DigitalOceanFactory($adapter);
        });

        $app->alias('digitalocean.factory', DigitalOceanFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerManager(Application $app)
    {
        $app->singleton('digitalocean', function ($app) {
            $config = $app['config'];
            $factory = $app['digitalocean.factory'];

            return new DigitalOceanManager($config, $factory);
        });

        $app->alias('digitalocean', DigitalOceanManager::class);
    }

    /**
     * Register the bindings.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerBindings(Application $app)
    {
        $app->bind('digitalocean.connection', function ($app) {
            $manager = $app['digitalocean'];

            return $manager->connection();
        });

        $app->alias('digitalocean.connection', DigitalOceanV2::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'digitalocean.adapterfactory',
            'digitalocean.factory',
            'digitalocean',
            'digitalocean.connection',
        ];
    }
}
