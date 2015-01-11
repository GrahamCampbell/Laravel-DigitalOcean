<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\DigitalOcean\Adapters;

use GrahamCampbell\DigitalOcean\Adapters\BuzzConnector;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the buzz connector test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class BuzzConnectorTest extends AbstractTestCase
{
    public function testConnectStandard()
    {
        $connector = $this->getBuzzConnector();

        $return = $connector->connect(['token' => 'your-token']);

        $this->assertInstanceOf('DigitalOceanV2\Adapter\BuzzAdapter', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConnectWithoutToken()
    {
        $connector = $this->getBuzzConnector();

        $connector->connect([]);
    }

    protected function getBuzzConnector()
    {
        return new BuzzConnector();
    }
}
