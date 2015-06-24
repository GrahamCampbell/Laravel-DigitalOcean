<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean;

use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory as AdapterFactory;
use GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * This is the digitalocean service provider class.
 *
 * @author Graham Campbell <graham@cachethq.io>
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
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/digitalocean.php');

        if (class_exists('Illuminate\Foundation\Application', false)) {
            $this->publishes([$source => config_path('digitalocean.php')]);
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
        ];
    }
}
