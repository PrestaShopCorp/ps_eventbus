<?php

namespace PrestaShop\Module\PsEventbus\Tests\Mocks\Handler;

use PrestaShop\Sentry\Handler\ErrorHandlerInterface;

class ErrorHandlerMock implements ErrorHandlerInterface
{
    public function handle($error, $code = null, $throw = true, $data = null)
    {
    }
}
