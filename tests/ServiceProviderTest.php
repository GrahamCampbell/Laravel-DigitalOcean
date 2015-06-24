<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\DigitalOcean;

use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory as AdapterFactory;
use GrahamCampbell\DigitalOcean\DigitalOceanManager;
use GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * This is the service provider test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testAdapterFactoryIsInjectable()
    {
        $this->assertIsInjectable(AdapterFactory::class);
    }

    public function testDigitalOceanFactoryIsInjectable()
    {
        $this->assertIsInjectable(DigitalOceanFactory::class);
    }

    public function testDigitalOceanManagerIsInjectable()
    {
        $this->assertIsInjectable(DigitalOceanManager::class);
    }
}
