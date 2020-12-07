<?php

namespace PrestaShop\Module\PsEventbus\Service;

use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Ring\Exception\ConnectException;
use PrestaShop\Module\PsEventbus\Api\EventBusProxyClient;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Formatter\JsonFormatter;

class ProxyService
{
    /**
     * @var EventBusProxyClient
     */
    private $eventBusProxyClient;
    /**
     * @var CompressionService
     */
    private $compressionService;
    /**
     * @var JsonFormatter
     */
    private $jsonFormatter;

    public function __construct(
        EventBusProxyClient $eventBusProxyClient,
        CompressionService $compressionService,
        JsonFormatter $jsonFormatter
    ) {
        $this->eventBusProxyClient = $eventBusProxyClient;
        $this->compressionService = $compressionService;
        $this->jsonFormatter = $jsonFormatter;
    }

    /**
     * @param string $jobId
     * @param array $data
     *
     * @return array
     *
     * @throws EnvVarException
     */
    public function upload($jobId, $data)
    {
        $dataJson = $this->jsonFormatter->formatNewlineJsonString($data);

        try {
            $response = $this->eventBusProxyClient->upload($jobId, $dataJson);
        } catch (ClientException $exception) {
            return ['error' => $exception->getMessage()];
        } catch (ConnectException $exception) {
            return ['error' => $exception->getMessage()];
        }

        return $response;
    }

    /**
     * @param string $jobId
     * @param array $data
     *
     * @return array
     *
     * @throws EnvVarException
     */
    public function delete($jobId, $data)
    {
        try {
            $compressedData = $this->compressionService->gzipCompressData($data);
        } catch (Exception $exception) {
            return ['error' => $exception->getMessage()];
        }

        try {
            $response = $this->eventBusProxyClient->delete($jobId, $compressedData);
        } catch (ClientException $exception) {
            return ['error' => $exception->getMessage()];
        }

        return $response;
    }
}
