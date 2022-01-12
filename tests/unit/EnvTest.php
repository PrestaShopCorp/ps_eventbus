<?php

use Dotenv\Dotenv;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Config\Env;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;

/**
 * @Features("env")
 * @Stories("get env values")
 */
class EnvTest extends BaseTestCase
{
    public function testDecorateSpecificPrice()
    {
        $dotenv = Dotenv::create(_PS_MODULE_DIR_ . 'ps_eventbus/', '.env.dist');
        $dotenv->load();
        $env = new Env();
        $url = $env->get('SENTRY_CREDENTIALS');
        $this->assertEquals('SENTRY_CREDENTIALS_KEY', $url);

        $timeout = $env->get('PROXY_TIMEOUT');
        $this->assertEquals(Config::PROXY_TIMEOUT, $timeout);
    }
}
