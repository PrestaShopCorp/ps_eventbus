<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\ServiceContainer;

use PrestaShop\Module\PsEventbus\ServiceContainer\Contract\IServiceProvider;
use PrestaShop\Module\PsEventbus\ServiceContainer\Contract\ISingletonService;
use PrestaShop\Module\PsEventbus\ServiceContainer\Exception\ParameterNotFoundException;
use PrestaShop\Module\PsEventbus\ServiceContainer\Exception\ProviderNotFoundException;
use PrestaShop\Module\PsEventbus\ServiceContainer\Exception\ServiceNotFoundException;

class ServiceContainer
{
    /**
     * @var string
     */
    protected $configPath;

    /**
     * @var array<mixed>
     */
    protected $config = [];

    /**
     * @var array<mixed>
     */
    protected $services = [];

    /**
     * @var \Closure[]
     */
    protected $providers = [];

    /**
     * @var string[]
     */
    protected $provides = [
        Provider\ApiProvider::class,
        Provider\CommonProvider::class,
        Provider\RepositoryProvider::class,
        Provider\ServiceProvider::class,
    ];

    /**
     * @param string $configPath
     */
    public function __construct($configPath)
    {
        $this->configPath = $configPath;
    }

    /**
     * @param string $configPath
     *
     * @return ServiceContainer
     */
    public static function createInstance($configPath)
    {
        $container = new ServiceContainer($configPath);
        $container->loadConfig();
        $container->init();

        return $container;
    }

    /**
     * @return void
     */
    public function loadConfig()
    {
        $this->config = require $this->configPath;
    }

    /**
     * @return void
     */
    public function init()
    {
        foreach ($this->provides as $provider) {
            if (is_a($provider, IServiceProvider::class, true)) {
                (new $provider())->provide($this);
            }
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws ServiceNotFoundException
     * @throws ProviderNotFoundException
     */
    public function get($name)
    {
        if ($this->hasService($name)) {
            return $this->services[$name];
        }

        if ($this->hasProvider($name)) {
            $callback = $this->getProvider($name);
            $service = $callback();
        } else {
            $service = $this->provideInstanceFromClassname($name);
        }

        if (null === $service) {
            throw new ServiceNotFoundException('Service Not Found: ' . $name);
        }

        $this->set($name, $service);

        return $service;
    }

    /**
     * @param string $name
     *
     * @return mixed
     *
     * @throws ServiceNotFoundException
     * @throws ProviderNotFoundException
     */
    public function getService($name)
    {
        return $this->get($name);
    }

    /**
     * @param mixed $name
     *
     * @return bool
     */
    public function hasService($name)
    {
        return array_key_exists($name, $this->services);
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return void
     */
    public function set($name, $value)
    {
        $this->services[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws ParameterNotFoundException
     */
    public function getParameter($name)
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }
        throw new ParameterNotFoundException('Configuration parameter "' . $name . '" not found.');
    }

    /**
     * @param string $name
     * @param string $default
     *
     * @return string
     */
    public function getParameterWithDefault($name, $default)
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasParameter($name)
    {
        return array_key_exists($name, $this->config);
    }

    /**
     * @param string $name
     *
     * @return \Closure
     *
     * @throws ProviderNotFoundException
     */
    public function getProvider($name)
    {
        if (array_key_exists($name, $this->providers)) {
            return $this->providers[$name];
        }
        throw new ProviderNotFoundException('Provider "' . $name . '" not found.');
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasProvider($name)
    {
        return array_key_exists($name, $this->providers);
    }

    /**
     * @param string $name
     * @param \Closure $provider
     *
     * @return void
     */
    public function registerProvider($name, \Closure $provider)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * @param string $className
     *
     * @return mixed
     */
    protected function provideInstanceFromClassname($className)
    {
        if (is_a($className, ISingletonService::class, true)) {
            return $className::getInstance($this);
        }

        return null;
    }
}
