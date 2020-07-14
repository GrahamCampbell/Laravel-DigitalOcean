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

namespace GrahamCampbell\Tests\DigitalOcean\Auth;

use GrahamCampbell\DigitalOcean\Auth\Authenticator\TokenAuthenticator;
use GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory;
use GrahamCampbell\Tests\DigitalOcean\AbstractTestCase;
use InvalidArgumentException;
use TypeError;

/**
 * This is the authenticator factory test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AuthenticatorFactoryTest extends AbstractTestCase
{
    public function testMakeTokenAuthenticator()
    {
        $return = $this->getFactory()->make('token');

        $this->assertInstanceOf(TokenAuthenticator::class, $return);
    }

    public function testMakeInvalidAuthenticator()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported authentication method [foo].');

        $this->getFactory()->make('foo');
    }

    public function testMakeNoAuthenticator()
    {
        $this->expectException(TypeError::class);

        $this->getFactory()->make(null);
    }

    protected function getFactory()
    {
        return new AuthenticatorFactory();
    }
}
