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

use DigitalOceanV2\Adapter\BuzzAdapter;
use GrahamCampbell\DigitalOcean\Adapters\BuzzConnector;
use GrahamCampbell\TestBench\AbstractTestCase;
use InvalidArgumentException;

/**
 * This is the buzz connector test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class BuzzConnectorTest extends AbstractTestCase
{
    public function testConnectStandard()
    {
        $connector = $this->getBuzzConnector();

        $return = $connector->connect(['token' => 'your-token']);

        $this->assertInstanceOf(BuzzAdapter::class, $return);
    }

    public function testConnectWithoutToken()
    {
        $connector = $this->getBuzzConnector();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The buzz connector requires configuration.');

        $connector->connect([]);
    }

    protected function getBuzzConnector()
    {
        return new BuzzConnector();
    }
}
