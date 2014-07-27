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

namespace GrahamCampbell\Tests\DigitalOcean;

use Mockery;
use GrahamCampbell\DigitalOcean\DigitalOceanManager;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;

/**
 * This is the digitalocean manager test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
 */
class DigitalOceanManagerTest extends AbstractTestBenchTestCase
{
    public function testCreateConnection()
    {
        $config = array('token' => 'your-token');

        $manager = $this->getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('graham-campbell/digitalocean::default')->andReturn('main');

        $this->assertEquals($manager->getConnections(), array());

        $return = $manager->connection();

        $this->assertInstanceOf('DigitalOceanV2\DigitalOceanV2', $return);

        $this->assertArrayHasKey('main', $manager->getConnections());
    }

    protected function getManager(array $config)
    {
        $repo = Mockery::mock('Illuminate\Config\Repository');
        $factory = Mockery::mock('GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory');

        $manager = new DigitalOceanManager($repo, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('graham-campbell/digitalocean::connections')->andReturn(array('main' => $config));

        $config['name'] = 'main';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock('DigitalOceanV2\DigitalOceanV2'));

        return $manager;
    }
}
