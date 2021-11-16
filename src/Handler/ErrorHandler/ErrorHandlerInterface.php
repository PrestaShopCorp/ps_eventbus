<?php

namespace PrestaShop\Module\PsEventbus\Handler\ErrorHandler;

interface ErrorHandlerInterface
{
    public function handle($error, $code = null, $throw = true, $data = null);
}
