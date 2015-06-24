<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\DigitalOcean\Facades;

use GrahamCampbell\DigitalOcean\DigitalOceanManager;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
use GrahamCampbell\TestBenchCore\FacadeTrait;
use GrahamCampbell\Tests\DigitalOcean\AbstractTestCase;

/**
 * This is the digitalocean facade test class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class DigitalOceanTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'digitalocean';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return DigitalOcean::class;
    }

    /**
     * Get the facade route.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return DigitalOceanManager::class;
    }
}
