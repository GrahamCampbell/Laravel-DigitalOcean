<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean\Adapters;

use DigitalOceanV2\Adapter\GuzzleHttpAdapter;
use GrahamCampbell\Manager\ConnectorInterface;
use InvalidArgumentException;

/**
 * This is the guzzlehttp connector class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GuzzleHttpConnector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\Adapter\GuzzleHttpAdapter
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
            throw new InvalidArgumentException('The guzzlehttp connector requires configuration.');
        }

        return array_only($config, ['token']);
    }

    /**
     * Get the guzzlehttp adapter.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\Adapter\GuzzleHttpAdapter
     */
    protected function getAdapter(array $config)
    {
        return new GuzzleHttpAdapter($config['token']);
    }
}
