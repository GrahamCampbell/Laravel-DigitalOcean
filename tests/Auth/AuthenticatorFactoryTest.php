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

namespace GrahamCampbell\Tests\DigitalOcean\Auth;

use GrahamCampbell\DigitalOcean\Auth\Authenticator\TokenAuthenticator;
use GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory;
use GrahamCampbell\Tests\DigitalOcean\AbstractTestCase;
use InvalidArgumentException;
use TypeError;

/**
 * This is the authenticator factory test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class AuthenticatorFactoryTest extends AbstractTestCase
{
    public function testMakeTokenAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        self::assertInstanceOf(TokenAuthenticator::class, $factory->make('token'));
    }

    public function testMakeInvalidAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported authentication method [foo].');

        $factory->make('foo');
    }

    public function testMakeNoAuthenticator(): void
    {
        $factory = new AuthenticatorFactory();

        $this->expectException(TypeError::class);

        $factory->make(null);
    }
}
