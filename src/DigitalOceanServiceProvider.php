<?php

declare(strict_types=1);

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean;

use DigitalOceanV2\Client;
use GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory;
use GrahamCampbell\DigitalOcean\HttpClient\BuilderFactory;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory as GuzzlePsrFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the digitalocean service provider class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
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
        $this->registerHttpClientFactory();
        $this->registerAuthFactory();
        $this->registerDigitalOceanFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the http client factory class.
     *
     * @return void
     */
    protected function registerHttpClientFactory()
    {
        $this->app->singleton('digitalocean.httpclientfactory', function () {
            $psrFactory = new GuzzlePsrFactory();

            return new BuilderFactory(
                new GuzzleClient(['connect_timeout' => 10, 'timeout' => 30]),
                $psrFactory,
                $psrFactory,
                $psrFactory,
            );
        });

        $this->app->alias('digitalocean.httpclientfactory', BuilderFactory::class);
    }

    /**
     * Register the auth factory class.
     *
     * @return void
     */
    protected function registerAuthFactory()
    {
        $this->app->singleton('digitalocean.authfactory', function () {
            return new AuthenticatorFactory();
        });

        $this->app->alias('digitalocean.authfactory', AuthenticatorFactory::class);
    }

    /**
     * Register the digitalocean factory class.
     *
     * @return void
     */
    protected function registerDigitalOceanFactory()
    {
        $this->app->singleton('digitalocean.factory', function (Container $app) {
            $builder = $app['digitalocean.httpclientfactory'];
            $auth = $app['digitalocean.authfactory'];

            return new DigitalOceanFactory($builder, $auth);
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

        $this->app->alias('digitalocean.connection', Client::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'digitalocean.httpclientfactory',
            'digitalocean.authfactory',
            'digitalocean.factory',
            'digitalocean',
            'digitalocean.connection',
        ];
    }
}
