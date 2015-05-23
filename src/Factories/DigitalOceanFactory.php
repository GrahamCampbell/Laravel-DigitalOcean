<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean\Factories;

use DigitalOceanV2\DigitalOceanV2;
use GrahamCampbell\DigitalOcean\Adapters\ConnectionFactory as AdapterFactory;

/**
 * This is the digitalocean factory class.
 *
 * @author Graham Campbell <graham@cachethq.io>
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
