<?php

namespace PrestaShop\Module\PsEventbus\Service;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Ring\Exception\ConnectException;
use PrestaShop\Module\PsEventbus\Api\EventBusProxyClient;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Formatter\JsonFormatter;
use PrestaShop\Sentry\Handler\ErrorHandlerInterface;

class ProxyService implements ProxyServiceInterface
{
    /**
     * @var EventBusProxyClient
     */
    private $eventBusProxyClient;
    /**
     * @var JsonFormatter
     */
    private $jsonFormatter;
    /**
     * @var ErrorHandlerInterface
     */
    private $errorHandler;

    public function __construct(EventBusProxyClient $eventBusProxyClient, JsonFormatter $jsonFormatter, ErrorHandlerInterface $errorHandler)
    {
        $this->eventBusProxyClient = $eventBusProxyClient;
        $this->jsonFormatter = $jsonFormatter;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param string $jobId
     * @param array $data
     * @param int $scriptStartTime
     *
     * @return array
     *
     * @throws EnvVarException
     */
    public function upload($jobId, $data, $scriptStartTime)
    {
        $dataJson = $this->jsonFormatter->formatNewlineJsonString($data);

        try {
            $response = $this->eventBusProxyClient->upload($jobId, $dataJson, $scriptStartTime);
        } catch (ClientException $exception) {
            $this->errorHandler->handle($exception);

            return ['error' => $exception->getMessage()];
        } catch (ConnectException $exception) {
            $this->errorHandler->handle($exception);

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
        $dataJson = $this->jsonFormatter->formatNewlineJsonString($data);

        try {
            $response = $this->eventBusProxyClient->uploadDelete($jobId, $dataJson);
        } catch (ClientException $exception) {
            $this->errorHandler->handle($exception);

            return ['error' => $exception->getMessage()];
        }

        return $response;
    }
}
