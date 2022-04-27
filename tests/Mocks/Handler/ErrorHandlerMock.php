<?php

namespace PrestaShop\Module\PsEventbus\Tests\Mocks\Handler;

use Module;
use PrestaShop\Sentry\Handler\ErrorHandlerInterface;
use Sentry\Severity;
use Throwable;

class ErrorHandlerMock implements ErrorHandlerInterface
{
    public function handle(Throwable $error): void
    {
    }

    public function setTags(array $tags): void
    {
    }

    public function setLevel(Severity $level): void
    {
    }

    public function setUser(array $data, bool $merge = false): void
    {
    }

    public function setModuleInfo(Module $module): void
    {
    }
}
