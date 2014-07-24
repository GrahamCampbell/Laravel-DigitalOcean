<?php

/**
 * This file is part of Laravel DigitalOcean by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\DigitalOcean;

use Illuminate\Support\ServiceProvider;

/**
 * This is the digitalocean service provider class.
 *
 * @package    Laravel-DigitalOcean
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-DigitalOcean
 */
class DigitalOceanServiceProvider extends ServiceProvider
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
        $this->package('graham-campbell/digitalocean', 'graham-campbell/digitalocean', __DIR__);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDigitalOceanManager();
    }

    /**
     * Register the digitalocean manager class.
     *
     * @return void
     */
    protected function registerDigitalOceanManager()
    {
        $this->app->bindShared('digitalocean', function ($app) {
            $config = $app['config'];
            $factory = new Factories\DigitalOceanFactory();

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
        return array(
            'digitalocean'
        );
    }
}
