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
use DigitalOceanV2\HttpClient\Builder;
use GrahamCampbell\DigitalOcean\Auth\Authenticator\AuthenticatorInterface;
use GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory;
use GrahamCampbell\DigitalOcean\HttpClient\BuilderFactory;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * This is the DigitalOcean factory class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class DigitalOceanFactory
{
    /**
     * The http client builder factory instance.
     *
     * @var \GrahamCampbell\DigitalOcean\HttpClient\BuilderFactory
     */
    private BuilderFactory $builder;

    /**
     * The authenticator factory instance.
     *
     * @var \GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory
     */
    private AuthenticatorFactory $auth;

    /**
     * Create a new DigitalOcean factory instance.
     *
     * @param \GrahamCampbell\DigitalOcean\HttpClient\BuilderFactory $builder
     * @param \GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory $auth
     *
     * @return void
     */
    public function __construct(BuilderFactory $builder, AuthenticatorFactory $auth)
    {
        $this->builder = $builder;
        $this->auth = $auth;
    }

    /**
     * Make a new DigitalOcean client.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \DigitalOceanV2\Client
     */
    public function make(array $config): Client
    {
        $client = new Client($this->getBuilder($config));

        if (!array_key_exists('method', $config)) {
            throw new InvalidArgumentException('The DigitalOcean factory requires an auth method.');
        }

        if ($url = Arr::get($config, 'url')) {
            $client->setUrl($url);
        }

        if ($config['method'] === 'none') {
            return $client;
        }

        return $this->getAuthenticator($config['method'])->with($client)->authenticate($config);
    }

    /**
     * Get the http client builder.
     *
     * @return \DigitalOceanV2\HttpClient\Builder
     */
    protected function getBuilder(): Builder
    {
        return $this->builder->make();
    }

    /**
     * Get the authenticator.
     *
     * @throws \InvalidArgumentException
     *
     * @return \GrahamCampbell\DigitalOcean\Auth\Authenticator\AuthenticatorInterface
     */
    protected function getAuthenticator(string $method): AuthenticatorInterface
    {
        return $this->auth->make($method);
    }
}
