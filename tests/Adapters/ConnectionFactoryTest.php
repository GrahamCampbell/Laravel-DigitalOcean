<?php

/**
 * This file is part of Laravel DigitalOcean by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at http://bit.ly/UWsjkb.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\DigitalOcean\Adapters;

use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory;
use GrahamCampbell\TestBench\AbstractTestCase;
use Mockery;

/**
 * This is the adapter connection factory test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
 */
class ConnectionFactoryTest extends AbstractTestCase
{
    public function testMake()
    {
        $factory = $this->getMockedFactory();

        $return = $factory->make(array('driver' => 'buzz', 'token' => 'your-token', 'name' => 'main'));

        $this->assertInstanceOf('DigitalOceanV2\Adapter\AdapterInterface', $return);
    }

    public function createDataProvider()
    {
        return array(
            array('buzz', 'BuzzConnector'),
            array('guzzle', 'GuzzleConnector'),
        );
    }

    /**
     * @dataProvider createDataProvider
     */
    public function testCreateWorkingDriver($driver, $class)
    {
        $factory = $this->getConnectionFactory();

        $return = $factory->createConnector(array('driver' => $driver));

        $this->assertInstanceOf('GrahamCampbell\DigitalOcean\Adapters\\'.$class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateEmptyDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $factory->createConnector(array());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateUnsupportedDriverConnector()
    {
        $factory = $this->getConnectionFactory();

        $factory->createConnector(array('driver' => 'unsupported'));
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
            ->with(array('name' => 'main', 'driver' => 'buzz', 'token' => 'your-token'))
            ->andReturn(Mockery::mock('DigitalOceanV2\Adapter\BuzzAdapter'));

        $mock->shouldReceive('createConnector')->once()
            ->with(array('name' => 'main', 'driver' => 'buzz', 'token' => 'your-token'))
            ->andReturn($connector);

        return $mock;
    }
}
