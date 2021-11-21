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
use GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory;
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
     * The authenticator factory instance.
     *
     * @var \GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory
     */
    protected $auth;

    /**
     * Create a new DigitalOcean factory instance.
     *
     * @param \GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory $auth
     *
     * @return void
     */
    public function __construct(AuthenticatorFactory $auth)
    {
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
    public function make(array $config)
    {
        $client = new Client();

        if (!array_key_exists('method', $config)) {
            throw new InvalidArgumentException('The DigitalOcean factory requires an auth method.');
        }

        if ($url = Arr::get($config, 'url')) {
            $client->setUrl($url);
        }

        if ($config['method'] === 'none') {
            return $client;
        }

        return $this->auth->make($config['method'])->with($client)->authenticate($config);
    }
}
