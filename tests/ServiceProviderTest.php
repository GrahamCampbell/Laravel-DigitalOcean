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

namespace GrahamCampbell\Tests\DigitalOcean;

use DigitalOceanV2\Client;
use GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory;
use GrahamCampbell\DigitalOcean\DigitalOceanFactory;
use GrahamCampbell\DigitalOcean\DigitalOceanManager;
use GrahamCampbell\DigitalOcean\HttpClient\BuilderFactory;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testHttpClientFactoryIsInjectable()
    {
        $this->assertIsInjectable(BuilderFactory::class);
    }

    public function testAuthFactoryIsInjectable()
    {
        $this->assertIsInjectable(AuthenticatorFactory::class);
    }

    public function testDigitalOceanFactoryIsInjectable()
    {
        $this->assertIsInjectable(DigitalOceanFactory::class);
    }

    public function testDigitalOceanManagerIsInjectable()
    {
        $this->assertIsInjectable(DigitalOceanManager::class);
    }

    public function testBindings()
    {
        $this->assertIsInjectable(Client::class);

        $original = $this->app['digitalocean.connection'];
        $this->app['digitalocean']->reconnect();
        $new = $this->app['digitalocean.connection'];

        $this->assertNotSame($original, $new);
        $this->assertEquals($original, $new);
    }
}
