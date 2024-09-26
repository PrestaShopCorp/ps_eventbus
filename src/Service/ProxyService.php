<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

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
     * @param array<mixed> $data
     * @param int $scriptStartTime
     * @param bool $isFull
     *
     * @return array<mixed>
     *
     * @throws EnvVarException
     */
    public function upload($jobId, $data, $scriptStartTime, $isFull)
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
     * @param array<mixed> $data
     * @param int $scriptStartTime
     *
     * @return array<mixed>
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
