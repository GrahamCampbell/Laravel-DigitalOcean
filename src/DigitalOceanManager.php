<?php

declare(strict_types=1);

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean;

use DigitalOceanV2\Client;
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * This is the digitalocean manager class.
 *
 * @method \DigitalOceanV2\Client                         connection(string|null $name = null)
 * @method \DigitalOceanV2\Client                         reconnect(string|null $name = null)
 * @method void                                           disconnect(string|null $name = null)
 * @method array<string,\DigitalOceanV2\Client>           getConnections()
 * @method \DigitalOceanV2\Api\Account                    account()
 * @method \DigitalOceanV2\Api\Action                     action()
 * @method \DigitalOceanV2\Api\CdnEndpoint                cdnEndpoint()
 * @method \DigitalOceanV2\Api\Certificate                certificate()
 * @method \DigitalOceanV2\Api\Database                   database()
 * @method \DigitalOceanV2\Api\Domain                     domain()
 * @method \DigitalOceanV2\Api\DomainRecord               domainRecord()
 * @method \DigitalOceanV2\Api\Droplet                    droplet()
 * @method \DigitalOceanV2\Api\FloatingIp                 floatingIp()
 * @method \DigitalOceanV2\Api\Image                      image()
 * @method \DigitalOceanV2\Api\Key                        key()
 * @method \DigitalOceanV2\Api\LoadBalancer               loadBalancer()
 * @method \DigitalOceanV2\Api\Monitoring                 monitoring()
 * @method \DigitalOceanV2\Api\ProjectResource            projectResource()
 * @method \DigitalOceanV2\Api\Region                     region()
 * @method \DigitalOceanV2\Api\ReservedIp                 reservedIp()
 * @method \DigitalOceanV2\Api\Size                       size()
 * @method \DigitalOceanV2\Api\Snapshot                   snapshot()
 * @method \DigitalOceanV2\Api\Tag                        tag()
 * @method \DigitalOceanV2\Api\Volume                     volume()
 * @method \DigitalOceanV2\Api\Vpc                        vpc()
 * @method void                                           authenticate(string $token)
 * @method void                                           setUrl(string $url)
 * @method \Psr\Http\Message\ResponseInterface|null       getLastResponse()
 * @method \Http\Client\Common\HttpMethodsClientInterface getHttpClient()
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class DigitalOceanManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \GrahamCampbell\DigitalOcean\DigitalOceanFactory
     */
    protected DigitalOceanFactory $factory;

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
     * @return \DigitalOceanV2\Client
     */
    protected function createConnection(array $config): Client
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName(): string
    {
        return 'digitalocean';
    }

    /**
     * Get the factory instance.
     *
     * @return \GrahamCampbell\DigitalOcean\DigitalOceanFactory
     */
    public function getFactory(): DigitalOceanFactory
    {
        return $this->factory;
    }
}
