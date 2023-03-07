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

namespace GrahamCampbell\Tests\DigitalOcean;

use DigitalOceanV2\Client;
use GrahamCampbell\DigitalOcean\Auth\AuthenticatorFactory;
use GrahamCampbell\DigitalOcean\DigitalOceanFactory;
use GrahamCampbell\DigitalOcean\HttpClient\BuilderFactory;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory as GuzzlePsrFactory;
use Http\Client\Common\HttpMethodsClientInterface;
use Illuminate\Contracts\Cache\Factory;
use InvalidArgumentException;

/**
 * This is the digitalocean factory test class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class DigitalOceanFactoryTest extends AbstractTestBenchTestCase
{
    public function testMakeStandard(): void
    {
        $factory = self::getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token']);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeStandardExplicitUrl(): void
    {
        $factory = self::getFactory();

        $client = $factory->make(['token' => 'your-token', 'method' => 'token', 'url' => 'https://api.example.com']);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeNoneMethod(): void
    {
        $factory = self::getFactory();

        $client = $factory->make(['method' => 'none']);

        self::assertInstanceOf(Client::class, $client);
        self::assertInstanceOf(HttpMethodsClientInterface::class, $client->getHttpClient());
    }

    public function testMakeInvalidMethod(): void
    {
        $factory = self::getFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported authentication method [bar].');

        $factory->make(['method' => 'bar']);
    }

    public function testMakeEmpty(): void
    {
        $factory = self::getFactory();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The DigitalOcean factory requires an auth method.');

        $factory->make([]);
    }

    private static function getFactory(): DigitalOceanFactory
    {
        $psrFactory = new GuzzlePsrFactory();

        $builder = new BuilderFactory(
            new GuzzleClient(['connect_timeout' => 10, 'timeout' => 30]),
            $psrFactory,
            $psrFactory,
            $psrFactory,
        );

        return new DigitalOceanFactory($builder, new AuthenticatorFactory());
    }
}
