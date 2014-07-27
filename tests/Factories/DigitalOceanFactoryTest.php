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

namespace GrahamCampbell\Tests\DigitalOcean\Factories;

use Mockery;
use GrahamCampbell\Tests\DigitalOcean\AbstractTestCase;
use GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory;

/**
 * This is the filesystem factory test class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
 */
class DigitalOceanFactoryTest extends AbstractTestCase
{
    public function testMakeStandard()
    {
        $factory = $this->getFactory();

        $return = $factory->make(array('token'  => 'your-token'));

        $this->assertInstanceOf('DigitalOceanV2\DigitalOceanV2', $return);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeWithoutToken()
    {
        $factory = $this->getFactory();

        $factory->make(array());
    }

    protected function getFactory()
    {
        return new DigitalOceanFactory();
    }
}
