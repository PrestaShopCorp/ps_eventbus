<?php

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Api\EventBusProxyClient;
use PrestaShop\Module\PsEventbus\Formatter\JsonFormatter;
use PrestaShop\Module\PsEventbus\Service\ProxyService;

class ProxyServiceTest extends TestCase
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
        $this->segmentService = new ProxyService($this->eventBusProxyClient, $this->jsonFormatter);
    }

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
