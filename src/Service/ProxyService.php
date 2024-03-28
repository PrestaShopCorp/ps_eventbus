<?php

namespace PrestaShop\Module\PsEventbus\Service;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Ring\Exception\ConnectException;
use PrestaShop\Module\PsEventbus\Api\CollectorApiClient;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Formatter\JsonFormatter;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandlerInterface;

class ProxyService implements ProxyServiceInterface
{
    /**
     * @var CollectorApiClient
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

    public function __construct(CollectorApiClient $eventBusProxyClient, JsonFormatter $jsonFormatter, ErrorHandlerInterface $errorHandler)
    {
        $this->eventBusProxyClient = $eventBusProxyClient;
        $this->jsonFormatter = $jsonFormatter;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param string $jobId
     * @param array $data
     * @param int $scriptStartTime
     * @param bool $isFull
     *
     * @return array
     *
     * @throws EnvVarException
     */
    public function upload($jobId, $data, $scriptStartTime, bool $isFull = false)
    {
        $dataJson = $this->jsonFormatter->formatNewlineJsonString($data);

        try {
            return $this->eventBusProxyClient->upload($jobId, $dataJson, $scriptStartTime, $isFull);
        } catch (ClientException $exception) {
            $this->errorHandler->handle($exception);

            return ['error' => $exception->getMessage()];
        } catch (ConnectException $exception) {
            $this->errorHandler->handle(new \Exception($exception));

            return ['error' => $exception->getMessage()];
        }
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
    public function delete($jobId, $data, $scriptStartTime)
    {
        $dataJson = $this->jsonFormatter->formatNewlineJsonString($data);

        try {
            $response = $this->eventBusProxyClient->uploadDelete($jobId, $dataJson, $scriptStartTime);
        } catch (ClientException $exception) {
            $this->errorHandler->handle($exception);

            return ['error' => $exception->getMessage()];
        }

        return $response;
    }
}
