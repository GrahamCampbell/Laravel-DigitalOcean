<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\DigitalOcean\Factories;

use DigitalOceanV2\Adapter\AdapterInterface;
use DigitalOceanV2\DigitalOceanV2;
use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory;
use GrahamCampbell\DigitalOcean\DigitalOceanManager;
use GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory;
use GrahamCampbell\Tests\DigitalOcean\AbstractTestCase;
use Mockery;

/**
 * This is the digitalocean factory test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class DigitalOceanFactoryTest extends AbstractTestCase
{
    public function testMake()
    {
        $config = ['driver' => 'buzz', 'token'  => 'your-token'];

        $manager = Mockery::mock(DigitalOceanManager::class);

        $factory = $this->getMockedFactory($config, $manager);

        $return = $factory->make($config, $manager);

        $this->assertInstanceOf(DigitalOceanV2::class, $return);
    }

    public function testAdapter()
    {
        $factory = $this->getDigitalOceanFactory();

        $config = ['driver' => 'guzzle5', 'token'  => 'your-token'];

        $factory->getAdapter()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock(AdapterInterface::class));

        $return = $factory->createAdapter($config);

        $this->assertInstanceOf(AdapterInterface::class, $return);
    }

    protected function getDigitalOceanFactory()
    {
        $adapter = Mockery::mock(ConnectionFactory::class);

        return new DigitalOceanFactory($adapter);
    }

    protected function getMockedFactory($config, $manager)
    {
        $adapter = Mockery::mock(ConnectionFactory::class);

        $mock = Mockery::mock(DigitalOceanFactory::class.'[createAdapter]', [$adapter]);

        $mock->shouldReceive('createAdapter')->once()
            ->with($config)->andReturn(Mockery::mock(AdapterInterface::class));

        return $mock;
    }
}
