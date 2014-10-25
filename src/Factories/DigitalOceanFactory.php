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

namespace GrahamCampbell\DigitalOcean\Factories;

use DigitalOceanV2\DigitalOceanV2;
use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory as AdapterFactory;

/**
 * This is the digitalocean factory class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
 */
class DigitalOceanFactory
{
    /**
     * The adapter factory instance.
     *
     * @var \GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory
     */
    protected $adapter;

    /**
     * Create a new filesystem factory instance.
     *
     * @param \GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory $adapter
     *
     * @return void
     */
    public function __construct(AdapterFactory $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Make a new digitalocean client.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\DigitalOceanV2
     */
    public function make(array $config)
    {
        $adapter = $this->createAdapter($config);

        return new DigitalOceanV2($adapter);
    }

    /**
     * Establish an adapter connection.
     *
     * @param array $config
     *
     * @return \DigitalOceanV2\Adapter\AdapterInterface
     */
    public function createAdapter(array $config)
    {
        return $this->adapter->make($config);
    }

    /**
     * Get the adapter factory instance.
     *
     * @return \GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}
