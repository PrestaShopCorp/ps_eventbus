<?php

namespace PrestaShop\Module\PsEventbus\Tests\Mocks\Handler;

use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandlerInterface;

class ErrorHandlerMock implements ErrorHandlerInterface
{
    public function handle($error, $code = null, $throw = true, $data = null)
    {
    }
}
