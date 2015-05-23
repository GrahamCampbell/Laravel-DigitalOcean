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

use GrahamCampbell\DigitalOcean\Adapters\GuzzleConnector;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the guzzle connector test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class GuzzleConnectorTest extends AbstractTestCase
{
    public function testConnectStandard()
    {
        $connector = $this->getGuzzleConnector();

        $return = $connector->connect(['token' => 'your-token']);

        $this->assertInstanceOf('DigitalOceanV2\Adapter\GuzzleAdapter', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConnectWithoutTokent()
    {
        $connector = $this->getGuzzleConnector();

        $connector->connect([]);
    }

    protected function getGuzzleConnector()
    {
        return new GuzzleConnector();
    }
}
