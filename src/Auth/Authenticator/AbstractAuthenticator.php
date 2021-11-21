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
 * This is the abstract authenticator class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
abstract class AbstractAuthenticator implements AuthenticatorInterface
{
    /**
     * The client to perform the authentication on.
     *
     * @var \DigitalOceanV2\Client|null
     */
    protected $client;

    /**
     * Set the client to perform the authentication on.
     *
     * @param \DigitalOceanV2\Client $client
     *
     * @return \GrahamCampbell\DigitalOcean\Auth\Authenticator\AuthenticatorInterface
     */
    public function with(Client $client)
    {
        $this->client = $client;

        return $this;
    }
}
