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

namespace GrahamCampbell\DigitalOcean\Auth\Authenticator;

use DigitalOceanV2\Client;

/**
 * This is the authenticator interface.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
interface AuthenticatorInterface
{
    /**
     * Set the client to perform the authentication on.
     *
     * @param \DigitalOceanV2\Client $client
     *
     * @return \GrahamCampbell\DigitalOcean\Auth\Authenticator\AuthenticatorInterface
     */
    public function with(Client $client);

    /**
     * Authenticate the client, and return it.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \DigitalOceanV2\Client
     */
    public function authenticate(array $config);
}
