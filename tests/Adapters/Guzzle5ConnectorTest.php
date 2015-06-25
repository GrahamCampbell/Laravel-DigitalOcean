<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\DigitalOcean\Adapters;

use DigitalOceanV2\Adapter\Guzzle5Adapter;
use GrahamCampbell\DigitalOcean\Adapters\Guzzle5Connector;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the guzzle5 connector test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Guzzle5ConnectorTest extends AbstractTestCase
{
    public function testConnectStandard()
    {
        $connector = $this->getGuzzle5Connector();

        $return = $connector->connect(['token' => 'your-token']);

        $this->assertInstanceOf(Guzzle5Adapter::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConnectWithoutTokent()
    {
        $connector = $this->getGuzzle5Connector();

        $connector->connect([]);
    }

    protected function getGuzzle5Connector()
    {
        return new Guzzle5Connector();
    }
}
