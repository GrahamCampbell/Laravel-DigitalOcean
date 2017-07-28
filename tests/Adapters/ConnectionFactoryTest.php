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

namespace GrahamCampbell\Tests\DigitalOcean\Adapters;

use DigitalOceanV2\Adapter\AdapterInterface;
use DigitalOceanV2\Adapter\BuzzAdapter;
use GrahamCampbell\DigitalOcean\Adapters\BuzzConnector;
use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory;
use GrahamCampbell\DigitalOcean\Adapters\GuzzleConnector;
use GrahamCampbell\DigitalOcean\Adapters\GuzzleHttpConnector;
use GrahamCampbell\DigitalOcean\Adapters\LocalConnector;
use GrahamCampbell\TestBench\AbstractTestCase;
use Mockery;

/**
 * This is the adapter connection factory test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class ConnectionFactoryTest extends AbstractTestCase
{
    public function testMake()
    {
        $factory = $this->getMockedFactory();

        $return = $factory->make(['driver' => 'buzz', 'token' => 'your-token', 'name' => 'main']);

        $this->assertInstanceOf(AdapterInterface::class, $return);
    }

    public function createDataProvider()
    {
        return [
            ['buzz', BuzzConnector::class],
            ['guzzle', GuzzleConnector::class],
            ['guzzlehttp', GuzzleHttpConnector::class],
        ];
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreateWorkingDriver($driver, $class)
    {
        $factory = $this->getConnectionFactory();

        $return = $factory->createConnector(['driver' => $driver]);

        $this->assertInstanceOf($class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage A driver must be specified.
     */
    public function testCreateEmptyDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $factory->createConnector([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unsupported driver [unsupported].
     */
    public function testCreateUnsupportedDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $factory->createConnector(['driver' => 'unsupported']);
    }

    protected function getConnectionFactory()
    {
        return new ConnectionFactory();
    }

    protected function getMockedFactory()
    {
        $mock = Mockery::mock(ConnectionFactory::class.'[createConnector]');

        $connector = Mockery::mock(LocalConnector::class);

        $connector->shouldReceive('connect')->once()
            ->with(['name' => 'main', 'driver' => 'buzz', 'token' => 'your-token'])
            ->andReturn(Mockery::mock(BuzzAdapter::class));

        $mock->shouldReceive('createConnector')->once()
            ->with(['name' => 'main', 'driver' => 'buzz', 'token' => 'your-token'])
            ->andReturn($connector);

        return $mock;
    }
}
