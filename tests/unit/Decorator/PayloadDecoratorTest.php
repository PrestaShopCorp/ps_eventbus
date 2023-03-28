<?php

use PrestaShop\Module\PsEventbus\Decorator\PayloadDecorator;
use PrestaShop\Module\PsEventbus\Formatter\DateFormatter;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("decorator")
 * @Stories("payload decorator")
 */
class PayloadDecoratorTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @Stories("payload  decorator")
     * @Title("testPayloadDecorator")
     */
    public function testPayloadDecorator()
    {
        $dateFormatter = $this->createMock(DateFormatter::class);
        $dateFormatter->method('convertToIso8061')->willReturn('2020-01-01 00:00:00');

        $payloadDecorator = new PayloadDecorator($dateFormatter);
        $payload = [
            [
                'properties' => [
                    'created_at' => '2020-01-01 00:00:00',
                    'updated_at' => '2020-01-01 00:00:00',
                    'from' => '2020-01-01 00:00:00',
                    'to' => '2020-01-01 00:00:00',
                ],
            ],
        ];

        $payloadDecorator->convertDateFormat($payload);

        $this->assertEquals('2020-01-01 00:00:00', $payload[0]['properties']['created_at']);
        $this->assertEquals('2020-01-01 00:00:00', $payload[0]['properties']['updated_at']);
        $this->assertEquals('2020-01-01 00:00:00', $payload[0]['properties']['from']);
        $this->assertEquals('2020-01-01 00:00:00', $payload[0]['properties']['to']);
    }
}
