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

use GrahamCampbell\DigitalOcean\DigitalOceanManager;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Mockery;

/**
 * This is the digitalocean manager test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class DigitalOceanManagerTest extends AbstractTestBenchTestCase
{
    public function testCreateConnection()
    {
        $config = ['token' => 'your-token'];

        $manager = $this->getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('digitalocean.default')->andReturn('main');

        $this->assertSame([], $manager->getConnections());

        $return = $manager->connection();

        $this->assertInstanceOf('DigitalOceanV2\DigitalOceanV2', $return);

        $this->assertArrayHasKey('main', $manager->getConnections());
    }

    protected function getManager(array $config)
    {
        $repo = Mockery::mock('Illuminate\Contracts\Config\Repository');
        $factory = Mockery::mock('GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory');

        $manager = new DigitalOceanManager($repo, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('digitalocean.connections')->andReturn(['main' => $config]);

        $config['name'] = 'main';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock('DigitalOceanV2\DigitalOceanV2'));

        return $manager;
    }
}
