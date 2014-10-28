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

namespace GrahamCampbell\Tests\DigitalOcean\Factories;

use GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory;
use GrahamCampbell\Tests\DigitalOcean\AbstractTestCase;
use Mockery;

/**
 * This is the digitalocean factory test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
 */
class DigitalOceanFactoryTest extends AbstractTestCase
{
    public function testMake()
    {
        $config = ['driver' => 'buzz', 'token'  => 'your-token'];

        $manager = Mockery::mock('GrahamCampbell\DigitalOcean\DigitalOceanManager');

        $factory = $this->getMockedFactory($config, $manager);

        $return = $factory->make($config, $manager);

        $this->assertInstanceOf('DigitalOceanV2\DigitalOceanV2', $return);
    }

    public function testAdapter()
    {
        $factory = $this->getDigitalOceanFactory();

        $config = ['driver' => 'guzzle', 'token'  => 'your-token'];

        $factory->getAdapter()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock('DigitalOceanV2\Adapter\AdapterInterface'));

        $return = $factory->createAdapter($config);

        $this->assertInstanceOf('DigitalOceanV2\Adapter\AdapterInterface', $return);
    }

    protected function getDigitalOceanFactory()
    {
        $adapter = Mockery::mock('GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory');

        return new DigitalOceanFactory($adapter);
    }

    protected function getMockedFactory($config, $manager)
    {
        $adapter = Mockery::mock('GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory');

        $adapterMock = Mockery::mock('DigitalOceanV2\Adapter\AdapterInterface');

        $mock = Mockery::mock('GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory[createAdapter]', [$adapter]);

        $mock->shouldReceive('createAdapter')->once()
            ->with($config)
            ->andReturn($adapterMock);

        return $mock;
    }
}
