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

namespace GrahamCampbell\Tests\DigitalOcean\Adapter;

use DigitalOceanV2\Adapter\AdapterInterface;
use DigitalOceanV2\Adapter\BuzzAdapter;
use GrahamCampbell\DigitalOcean\Adapter\ConnectionFactory;
use GrahamCampbell\DigitalOcean\Adapter\Connector\BuzzConnector;
use GrahamCampbell\DigitalOcean\Adapter\Connector\ConnectorInterface;
use GrahamCampbell\DigitalOcean\Adapter\Connector\GuzzleConnector;
use GrahamCampbell\TestBench\AbstractTestCase;
use InvalidArgumentException;
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

    public function testCreateEmptyDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A driver must be specified.');

        $factory->createConnector([]);
    }

    public function testCreateUnsupportedDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported driver [unsupported].');

        $factory->createConnector(['driver' => 'unsupported']);
    }

    protected function getConnectionFactory()
    {
        return new ConnectionFactory();
    }

    protected function getMockedFactory()
    {
        $mock = Mockery::mock(ConnectionFactory::class.'[createConnector]');

        $connector = Mockery::mock(ConnectorInterface::class);

        $connector->shouldReceive('connect')->once()
            ->with(['name' => 'main', 'driver' => 'buzz', 'token' => 'your-token'])
            ->andReturn(Mockery::mock(BuzzAdapter::class));

        $mock->shouldReceive('createConnector')->once()
            ->with(['name' => 'main', 'driver' => 'buzz', 'token' => 'your-token'])
            ->andReturn($connector);

        return $mock;
    }
}
