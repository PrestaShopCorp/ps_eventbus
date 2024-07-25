<?php

namespace PrestaShop\Module\PsEventbus\Handler\ErrorHandler;

interface ErrorHandlerInterface
{
    /**
     * @param \Exception $error
     * @param mixed $code
     * @param bool|null $throw
     * @param array<mixed>|null $data
     *
     * @return void
     */
    public function handle($error, $code = null, $throw = null, $data = null);
}
