<?php

namespace PrestaShop\Module\PsEventbus\Tests\Extensions;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;
use PrestaShop\PrestaShop\Core\Foundation\IoC\Exception;
use SebastianBergmann\CodeCoverage\CodeCoverage;

class Boot implements BeforeFirstTestHook, AfterLastTestHook
{
    /**
     * @var CodeCoverage
     */
    private $coverage;

    public function executeBeforeFirstTest(): void
    {
        $this->coverage = new CodeCoverage();
        $this->coverage->filter()->addDirectoryToWhitelist(_PS_MODULE_DIR_ . '/ps_eventbus/src');
        $this->coverage->start('<name of test>');
    }

    public function executeAfterLastTest(): void
    {
        $this->coverage->stop();
        $writer = new \SebastianBergmann\CodeCoverage\Report\Clover();
        $writer->process($this->coverage, _PS_MODULE_DIR_ . '/ps_eventbus/tests/tmp/clover.xml');

        $writer = new \SebastianBergmann\CodeCoverage\Report\Html\Facade();
        $writer->process($this->coverage, _PS_MODULE_DIR_ . '/ps_eventbus/tests/tmp/code-coverage-report');
    }
}
