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

use DigitalOceanV2\Adapter\BuzzAdapter;
use InvalidArgumentException;
use GrahamCampbell\Manager\ConnectorInterface;

/**
 * This is the buzz connector class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class BuzzConnector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\Adapter\BuzzAdapter
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
            throw new InvalidArgumentException('The buzz connector requires configuration.');
        }

        return array_only($config, ['token']);
    }

    /**
     * Get the buzz adapter.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\Adapter\BuzzAdapter
     */
    protected function getAdapter(array $config)
    {
        return new BuzzAdapter($config['token']);
    }
}
