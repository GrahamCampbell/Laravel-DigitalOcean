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

namespace GrahamCampbell\DigitalOcean\Adapters;

use DigitalOceanV2\Adapter\GuzzleAdapter;
use GrahamCampbell\Manager\ConnectorInterface;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * This is the guzzle connector class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GuzzleConnector implements ConnectorInterface
{
    /**
     * Establish an adapter connection.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\Adapter\GuzzleAdapter
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
            throw new InvalidArgumentException('The guzzle connector requires configuration.');
        }

        return Arr::only($config, ['token']);
    }

    /**
     * Get the guzzle adapter.
     *
     * @param string[] $config
     *
     * @return \DigitalOceanV2\Adapter\GuzzleAdapter
     */
    protected function getAdapter(array $config)
    {
        return new GuzzleAdapter($config['token']);
    }
}
