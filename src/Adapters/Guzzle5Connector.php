<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean\Adapters;

use DigitalOceanV2\Adapter\Guzzle5Adapter;
use GrahamCampbell\Manager\ConnectorInterface;

/**
 * This is the guzzle5 connector class.
 *
 * @author Graham Campbell <graham@mineuk.com>
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

        return array_only($config, ['token']);
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
