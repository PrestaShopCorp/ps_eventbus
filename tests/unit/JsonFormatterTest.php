<?php

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Formatter\JsonFormatter;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("formatter")
 * @Stories("json formatter")
 */
class JsonFormatterTest extends TestCase
{
    /**
     * @var JsonFormatter
     */
    private $jsonFormatter;

    protected function setUp()
    {
        parent::setUp();
        $this->jsonFormatter = new JsonFormatter();
    }

    /**
     * @Stories("json formatter")
     * @Title("testFormatNewlineJsonString")
     */
    public function testFormatNewlineJsonString()
    {
        $data = [
            ['test' => 'data'],
            ['test2' => 'data2'],
        ];

        $this->assertTrue(is_string($this->jsonFormatter->formatNewlineJsonString($data)));
        $this->assertRegExp("/\r\n/", $this->jsonFormatter->formatNewlineJsonString($data));
    }
}
