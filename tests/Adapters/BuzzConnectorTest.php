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

use GrahamCampbell\DigitalOcean\Adapters\BuzzConnector;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the buzz connector test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
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
