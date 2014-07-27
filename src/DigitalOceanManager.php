<?php

/**
 * This file is part of Laravel DigitalOcean by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\DigitalOcean;

use GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory;
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Config\Repository;

/**
 * This is the digitalocean manager class.
 *
 * @author    Graham Campbell <graham@mineuk.com>
 * @copyright 2014 Graham Campbell
 * @license   <https://github.com/GrahamCampbell/Laravel-DigitalOcean/blob/master/LICENSE.md> Apache 2.0
 */
class DigitalOceanManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @type \GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory
     */
    protected $factory;

    /**
     * Create a new digitalocean manager instance.
     *
     * @param \Illuminate\Config\Repository                              $config
     * @param \GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory $factory
     *
     * @return void
     */
    public function __construct(Repository $config, DigitalOceanFactory $factory)
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return \DigitalOceanV2\DigitalOceanV2
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
    {
        return 'graham-campbell/digitalocean';
    }

    /**
     * Get the factory instance.
     *
     * @return \GrahamCampbell\DigitalOcean\Factories\DigitalOceanFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }
}
