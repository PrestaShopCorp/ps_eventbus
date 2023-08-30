<?php

namespace PrestaShop\Module\PsEventbus\Service;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Ring\Exception\ConnectException;
use PrestaShop\Module\PsEventbus\Api\CollectorApiClient;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandlerInterface;

class ProxyService implements ProxyServiceInterface
{
    /**
     * @var CollectorApiClient
     */
    private $eventBusProxyClient;

    /**
     * @var ErrorHandlerInterface
     */
    private $errorHandler;

    public function __construct(CollectorApiClient $eventBusProxyClient, ErrorHandlerInterface $errorHandler)
    {
        $this->eventBusProxyClient = $eventBusProxyClient;
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
        try {
            $response = $this->eventBusProxyClient->upload($jobId, $data, $scriptStartTime, $isFull);
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
     * @param int $scriptStartTime
     *
     * @return array
     *
     * @throws EnvVarException
     */
    public function delete($jobId, $data, $scriptStartTime)
    {
        try {
            $response = $this->eventBusProxyClient->uploadDelete($jobId, $data, $scriptStartTime);
        } catch (ClientException $exception) {
            $this->errorHandler->handle($exception);

            return ['error' => $exception->getMessage()];
        } catch (ConnectException $exception) {
            $this->errorHandler->handle($exception);

            return ['error' => $exception->getMessage()];
        }

        return $response;
    }
}
