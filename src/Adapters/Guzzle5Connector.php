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

namespace GrahamCampbell\DigitalOcean\Adapters;

use DigitalOceanV2\Adapter\Guzzle5Adapter;
use GrahamCampbell\Manager\ConnectorInterface;

/**
 * This is the guzzle5 connector class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @guzzleright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
 */
class Guzzle5Connector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\Adapter\Guzzle5Adapter
     */
    public function connect(array $config)
    {
        $config = $this->getConfig($config);

        return $this->getAdapter($config);
    }

    /**
     * Get the configuration.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return string[]
     */
    protected function getConfig(array $config)
    {
        if (!array_key_exists('token', $config)) {
            throw new \InvalidArgumentException('The guzzle5 connector requires configuration.');
        }

        return array_only($config, array('token'));
    }

    /**
     * Get the guzzle5 adapter.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\Adapter\Guzzle5Adapter
     */
    protected function getAdapter(array $config)
    {
        return new Guzzle5Adapter($config['token']);
    }
}
