<?php

/*
 * This file is part of Laravel DigitalOcean.
 *
 * (c) Graham Campbell <graham@cachethq.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\DigitalOcean\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * This is the digitalocean facade class.
 *
 * @author Graham Campbell <graham@cachethq.io>
 */
class DigitalOcean extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'digitalocean';
    }
}
