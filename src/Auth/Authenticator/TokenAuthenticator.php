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

use InvalidArgumentException;

/**
 * This is the token authenticator class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
final class TokenAuthenticator extends AbstractAuthenticator
{
    /**
     * Authenticate the client, and return it.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return \DigitalOceanV2\Client
     */
    public function authenticate(array $config)
    {
        if (!$this->client) {
            throw new InvalidArgumentException('The client instance was not given to the authenticator.');
        }

        if (!array_key_exists('token', $config)) {
            throw new InvalidArgumentException('The token authenticator requires a token.');
        }

        $this->client->authenticate($config['token']);

        return $this->client;
    }
}
