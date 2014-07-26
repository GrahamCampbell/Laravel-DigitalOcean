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

namespace GrahamCampbell\DigitalOcean\Factories;

use DigitalOceanV2\Adapter\BuzzAdapter;
use DigitalOceanV2\DigitalOceanV2;

/**
 * This is the digitalocean factory class.
 *
 * @package    Laravel-DigitalOcean
 * @author     Graham Campbell
 * @copyright  Copyright 2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-DigitalOcean
 */
class DigitalOceanFactory
{
    /**
     * Make a new digitalocean client.
     *
     * @param  array  $config
     * @return \DigitalOceanV2\DigitalOceanV2
     */
    public function make(array $config)
    {
        $config = $this->getConfig($config);

        $adapter = $this->getAdapter($config);

        return new DigitalOceanV2($adapter);
    }

    /**
     * Get the configuration data.
     *
     * @param  array  $config
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getConfig(array $config)
    {
        if (!array_key_exists('token', $config)) {
            throw new \InvalidArgumentException('The digitalocean client requires configuration.');
        }

        return array_only($config, array('token'));
    }

    /**
     * Get the buzz adapter.
     *
     * @param  array  $config
     * @return \DigitalOceanV2\Adapter\BuzzAdapter
     */
    protected function getAdapter(array $config)
    {
        return new BuzzAdapter($config['token']);
    }
}
