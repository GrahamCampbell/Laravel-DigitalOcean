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

namespace GrahamCampbell\DigitalOcean\HttpClient;

use DigitalOceanV2\HttpClient\Builder;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * This is the http client builder factory class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
class BuilderFactory
{
    /**
     * The http client instance.
     *
     * @var \Psr\Http\Client\ClientInterface
     */
    private ClientInterface $httpClient;

    /**
     * The request factory instance.
     *
     * @var \Psr\Http\Message\RequestFactoryInterface
     */
    private RequestFactoryInterface $requestFactory;

    /**
     * The stream factory instance.
     *
     * @var \Psr\Http\Message\StreamFactoryInterface
     */
    private StreamFactoryInterface $streamFactory;

    /**
     * The uri factory instance.
     *
     * @var \Psr\Http\Message\UriFactoryInterface
     */
    private UriFactoryInterface $uriFactory;

    /**
     * Create a new connection factory instance.
     *
     * @param \Psr\Http\Client\ClientInterface          $httpClient
     * @param \Psr\Http\Message\RequestFactoryInterface $requestFactory
     * @param \Psr\Http\Message\StreamFactoryInterface  $streamFactory
     * @param \Psr\Http\Message\UriFactoryInterface     $uriFactory
     *
     * @return void
     */
    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory, UriFactoryInterface $uriFactory)
    {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->uriFactory = $uriFactory;
    }

    /**
     * Return a new http client builder.
     *
     * @return \DigitalOceanV2\HttpClient\Builder
     */
    public function make(): Builder
    {
        return new Builder($this->httpClient, $this->requestFactory, $this->streamFactory, $this->uriFactory);
    }
}
