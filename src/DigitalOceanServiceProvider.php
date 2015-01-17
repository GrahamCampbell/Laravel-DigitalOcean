<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean;

use Orchestra\Support\Providers\ServiceProvider;

/**
 * This is the digitalocean service provider class.
 *
 * @author Graham Campbell <graham@mineuk.com>
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
        $this->addConfigComponent('graham-campbell/digitalocean', 'graham-campbell/digitalocean', realpath(__DIR__.'/../config'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('digitalocean.factory', function ($app) {
            $adapter = new Adapters\ConnectionFactory();

            return new Factories\DigitalOceanFactory($adapter);
        });

        $this->app->alias('digitalocean.factory', 'GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory');
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('digitalocean', function ($app) {
            $config = $app['config'];
            $factory = $app['digitalocean.factory'];

            return new DigitalOceanManager($config, $factory);
        });

        $this->app->alias('digitalocean', 'GrahamCampbell\DigitalOcean\DigitalOceanManager');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'digitalocean',
            'digitalocean.factory',
        ];
    }
}
