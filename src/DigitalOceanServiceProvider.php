<?php

declare(strict_types=1);

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
use Illuminate\Contracts\Container\Container;
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
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__.'/../config/digitalocean.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('digitalocean.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('digitalocean');
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
        $this->registerAdapterFactory();
        $this->registerDigitalOceanFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the adapter factory class.
     *
     * @return void
     */
    protected function registerAdapterFactory()
    {
        $this->app->singleton('digitalocean.adapterfactory', function () {
            return new AdapterFactory();
        });

        $this->app->alias('digitalocean.adapterfactory', AdapterFactory::class);
    }

    /**
     * Register the digitalocean factory class.
     *
     * @return void
     */
    protected function registerDigitalOceanFactory()
    {
        $this->app->singleton('digitalocean.factory', function (Container $app) {
            $adapter = $app['digitalocean.adapterfactory'];

            return new DigitalOceanFactory($adapter);
        });

        $this->app->alias('digitalocean.factory', DigitalOceanFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('digitalocean', function (Container $app) {
            $config = $app['config'];
            $factory = $app['digitalocean.factory'];

            return new DigitalOceanManager($config, $factory);
        });

        $this->app->alias('digitalocean', DigitalOceanManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('digitalocean.connection', function (Container $app) {
            $manager = $app['digitalocean'];

            return $manager->connection();
        });

        $this->app->alias('digitalocean.connection', DigitalOceanV2::class);
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
