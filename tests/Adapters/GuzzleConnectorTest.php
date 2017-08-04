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

use DigitalOceanV2\Adapter\GuzzleAdapter;
use GrahamCampbell\DigitalOcean\Adapters\GuzzleConnector;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the guzzle connector test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GuzzleConnectorTest extends AbstractTestCase
{
    public function testConnectStandard()
    {
        $connector = $this->getGuzzleConnector();

        $return = $connector->connect(['token' => 'your-token']);

        $this->assertInstanceOf(GuzzleAdapter::class, $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The guzzle connector requires configuration.
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
