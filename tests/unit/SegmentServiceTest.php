<?php

use GuzzleHttp\Exception\ClientException;
use PrestaShop\Module\PsEventbus\Api\EventBusProxyClient;
use PrestaShop\Module\PsEventbus\Formatter\JsonFormatter;
use PrestaShop\Module\PsEventbus\Service\ProxyService;
use PrestaShop\Module\PsEventbus\Tests\Mocks\Handler\ErrorHandlerMock;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("synchronization")
 * @Stories("proxy service")
 */
class SegmentServiceTest extends BaseTestCase
{
    /**
     * @var ProxyService
     */
    private $segmentService;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var EventBusProxyClient
     */
    private $eventBusProxyClient;
    /**
     * @var JsonFormatter
     */
    private $jsonFormatter;

    public function setUp()
    {
        parent::setUp();
        $this->context = Context::getContext();
        $this->eventBusProxyClient = $this->createMock(EventBusProxyClient::class);
        $this->jsonFormatter = new JsonFormatter();
        $errorHandler = new ErrorHandlerMock();
        $this->segmentService = new ProxyService($this->eventBusProxyClient, $this->jsonFormatter, $errorHandler);
    }

    /**
     * @Stories("proxy service")
     * @Title("testValidUpload")
     */
    public function testValidUpload()
    {
        $data = ['important_server_data' => ':)'];
        $syncId = '12345';
        $jsonData = $this->jsonFormatter->formatNewlineJsonString($data);

        $this->eventBusProxyClient->method('upload')->willReturn([
            'status' => 'success',
            'httpCode' => 201,
            'body' => 'success',
        ]);

        $startDate = time();
        $this->assertTrue(is_array($this->segmentService->upload($syncId, $data, $startDate)));
        $this->assertArrayHasKey('httpCode', $this->segmentService->upload($syncId, $data, $startDate));
        $this->assertEquals(201, $this->segmentService->upload($syncId, $data, $startDate)['httpCode']);
    }

    public function testInvalidUpload()
    {
        $data = ['important_server_data' => ':)'];
        $syncId = '12345';
        $startDate = time();

        $clientException = $this->createMock(ClientException::class);
        $this->eventBusProxyClient->method('upload')->willThrowException($clientException);
        $this->assertArrayHasKey('error', $this->segmentService->upload($syncId, $data, $startDate));
    }
}
