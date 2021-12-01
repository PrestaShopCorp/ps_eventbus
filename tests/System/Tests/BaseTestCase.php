<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Tests;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * @var \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer
     */
    protected $container;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->container = new \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer(
            'ps_eventbus_test',
            __DIR__ . '/../'
        );
    }
}
