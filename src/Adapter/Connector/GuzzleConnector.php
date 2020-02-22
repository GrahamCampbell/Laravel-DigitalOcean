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

namespace GrahamCampbell\DigitalOcean\Adapter\Connector;

use DigitalOceanV2\Adapter\GuzzleHttpAdapter;
use GrahamCampbell\Manager\ConnectorInterface;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * This is the guzzle connector class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
final class GuzzleConnector implements ConnectorInterface
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
        $config = self::getConfig($config);

        return self::getAdapter($config);
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
    private static function getConfig(array $config)
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
     * @return \DigitalOceanV2\Adapter\GuzzleHttpAdapter
     */
    private static function getAdapter(array $config)
    {
        return new GuzzleHttpAdapter($config['token']);
    }
}
