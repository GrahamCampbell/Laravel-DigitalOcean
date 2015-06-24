<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * This is the digitalocean manager class.
 *
 * @method \DigitalOceanV2\Api\Action action()
 * @method \DigitalOceanV2\Api\Image image()
 * @method \DigitalOceanV2\Api\Domain domain()
 * @method \DigitalOceanV2\Api\DomainRecord domainRecord()
 * @method \DigitalOceanV2\Api\Size size()
 * @method \DigitalOceanV2\Api\Region region()
 * @method \DigitalOceanV2\Api\Key key()
 * @method \DigitalOceanV2\Api\Droplet droplet()
 * @method \DigitalOceanV2\Api\RateLimit rateLimit()
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class DigitalOceanManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \GrahamCampbell\DigitalOcean\DigitalOceanFactory
     */
    protected $factory;

    /**
     * Create a new digitalocean manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository          $config
     * @param \GrahamCampbell\DigitalOcean\DigitalOceanFactory $factory
     *
     * @return void
     */
    public function __construct(Repository $config, DigitalOceanFactory $factory)
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return \DigitalOceanV2\DigitalOceanV2
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
    {
        return 'digitalocean';
    }

    /**
     * Get the factory instance.
     *
     * @return \GrahamCampbell\DigitalOcean\DigitalOceanFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
