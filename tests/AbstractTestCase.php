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

use GrahamCampbell\DigitalOcean\DigitalOceanServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

/**
 * This is the abstract test case class.
 *
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return DigitalOceanServiceProvider::class;
    }
}
