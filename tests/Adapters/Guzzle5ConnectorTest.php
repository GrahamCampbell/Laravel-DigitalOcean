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

use GrahamCampbell\DigitalOcean\Adapters\Guzzle5Connector;
use GrahamCampbell\TestBench\AbstractTestCase;

/**
 * This is the guzzle5 connector test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
 */
class Guzzle5ConnectorTest extends AbstractTestCase
{
    public function testConnectStandard()
    {
        $connector = $this->getGuzzle5Connector();

        $return = $connector->connect(array('token' => 'your-token'));

        $this->assertInstanceOf('DigitalOceanV2\Adapter\Guzzle5Adapter', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConnectWithoutTokent()
    {
        $connector = $this->getGuzzle5Connector();

        $connector->connect(array());
    }

    protected function getGuzzle5Connector()
    {
        return new Guzzle5Connector();
    }
}
