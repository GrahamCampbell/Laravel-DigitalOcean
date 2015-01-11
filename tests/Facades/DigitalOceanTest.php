<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\DigitalOcean\Facades;

use GrahamCampbell\TestBench\Traits\FacadeTestCaseTrait;
use GrahamCampbell\Tests\DigitalOcean\AbstractTestCase;

/**
 * This is the digitalocean facade test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class DigitalOceanTest extends AbstractTestCase
{
    use FacadeTestCaseTrait;

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
        return 'GrahamCampbell\DigitalOcean\Facades\DigitalOcean';
    }

    /**
     * Get the facade route.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return 'GrahamCampbell\DigitalOcean\DigitalOceanManager';
    }
}
