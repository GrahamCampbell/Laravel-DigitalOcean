<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\DigitalOcean\Adapters;

use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory;
use GrahamCampbell\TestBench\AbstractTestCase;
use Mockery;

/**
 * This is the adapter connection factory test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class ConnectionFactoryTest extends AbstractTestCase
{
    public function testMake()
    {
        $factory = $this->getMockedFactory();

        $return = $factory->make(['driver' => 'buzz', 'token' => 'your-token', 'name' => 'main']);

        $this->assertInstanceOf('DigitalOceanV2\Adapter\AdapterInterface', $return);
    }

    public function createDataProvider()
    {
        return [
            ['buzz', 'BuzzConnector'],
            ['guzzle', 'GuzzleConnector'],
            ['guzzle5', 'Guzzle5Connector'],
        ];
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreateWorkingDriver($driver, $class)
    {
        $factory = $this->getConnectionFactory();

        $return = $factory->createConnector(['driver' => $driver]);

        $this->assertInstanceOf('GrahamCampbell\DigitalOcean\Adapters\\'.$class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateEmptyDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $factory->createConnector([]);
    }

    /**
     * @expectedException \InvalidArgumentException
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
        $mock = Mockery::mock('GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory[createConnector]');

        $connector = Mockery::mock('GrahamCampbell\DigitalOcean\Adapters\LocalConnector');

        $connector->shouldReceive('connect')->once()
            ->with(['name' => 'main', 'driver' => 'buzz', 'token' => 'your-token'])
            ->andReturn(Mockery::mock('DigitalOceanV2\Adapter\BuzzAdapter'));

        $mock->shouldReceive('createConnector')->once()
            ->with(['name' => 'main', 'driver' => 'buzz', 'token' => 'your-token'])
            ->andReturn($connector);

        return $mock;
    }
}
