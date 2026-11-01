<?php

namespace PrestaShop\Module\PsEventbus\Tests\Handler;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;

class ErrorHandlerTest extends TestCase
{
    /**
     * Sentry DSN on a port where nothing listens: reports are refused at once, without leaving the machine.
     */
    const CLOSED_PORT_DSN = 'https://public-key@127.0.0.1:9/42';

    const TAG_CALLS = [
        'getInstanceByName ps_accounts',
        'getInstanceByName ps_eventbus',
        'isEnabled ps_eventbus',
        'isInstalled ps_eventbus',
    ];

    public function testDoesNotLoadAnyModuleWhenBuilt()
    {
        $this->createErrorHandler();

        $this->assertSame([], \Module::$calls, 'The Sentry tags must only be built when an error is reported');
    }

    public function testBuildsTheSentryTagsOnceForSeveralReports()
    {
        $errorHandler = $this->createErrorHandler();

        $errorHandler->handle(new \Exception('first'), true);
        $errorHandler->handle(new \Exception('second'), true);

        $this->assertSame(self::TAG_CALLS, \Module::$calls);
    }

    public function testKeepsReportingWhenTheSentryTagsCannotBeBuilt()
    {
        $errorHandler = $this->createErrorHandler();

        try {
            \Module::$failWith = new \RuntimeException('database gone');
            $errorHandler->handle(new \Exception('first'), true);
            \Module::$failWith = new \Error('broken module');
            $errorHandler->handle(new \Exception('second'), true);
        } finally {
            \Module::$failWith = null;
        }
        $errorHandler->handle(new \Exception('third'), true);

        $this->assertSame(
            array_merge(['getInstanceByName ps_accounts', 'getInstanceByName ps_accounts'], self::TAG_CALLS),
            \Module::$calls,
            'Each report must try to build the tags until it succeeds'
        );
    }

    /**
     * @return ErrorHandler
     */
    private function createErrorHandler()
    {
        \Module::$calls = [];
        \Module::$failWith = null;

        return new ErrorHandler(self::CLOSED_PORT_DSN, 'test');
    }
}
