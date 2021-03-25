<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Exception\ApiException;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShopDatabaseException;

class SynchronizationService
{
    /**
     * @var EventbusSyncRepository
     */
    private $eventbusSyncRepository;
    /**
     * @var IncrementalSyncRepository
     */
    private $incrementalSyncRepository;
    /**
     * @var ProxyService
     */
    private $proxyService;

    public function __construct(EventbusSyncRepository $eventbusSyncRepository, IncrementalSyncRepository $incrementalSyncRepository, ProxyService $proxyService)
    {
        $this->eventbusSyncRepository = $eventbusSyncRepository;
        $this->incrementalSyncRepository = $incrementalSyncRepository;
        $this->proxyService = $proxyService;
    }

    /**
     * @param PaginatedApiDataProviderInterface $dataProvider
     * @param string $type
     * @param string $jobId
     * @param string $langIso
     * @param int $offset
     * @param int $limit
     * @param string $dateNow
     * @param int $scriptStartTime
     *
     * @return array
     *
     * @throws PrestaShopDatabaseException|EnvVarException|ApiException
     */
    public function handleFullSync(PaginatedApiDataProviderInterface $dataProvider, $type, $jobId, $langIso, $offset, $limit, $dateNow, $scriptStartTime)
    {
        $response = [];

        $data = $dataProvider->getFormattedData($offset, $limit, $langIso);

        if (!empty($data)) {
            $response = $this->proxyService->upload($jobId, $data, $scriptStartTime);

            if ($response['httpCode'] == 201) {
                $offset += $limit;
            }
        }

        $remainingObjects = (int) $dataProvider->getRemainingObjectsCount($offset, $langIso);

        if ($remainingObjects <= 0) {
            $remainingObjects = 0;
            $offset = 0;
        }

        $this->eventbusSyncRepository->updateTypeSync($type, $offset, $dateNow, $remainingObjects == 0, $langIso);

        return array_merge([
            'total_objects' => count($data),
            'has_remaining_objects' => $remainingObjects > 0,
            'remaining_objects' => $remainingObjects,
            'md5' => $this->getPayloadMd5($data),
        ], $response);
    }

    /**
     * @param PaginatedApiDataProviderInterface $dataProvider
     * @param string $type
     * @param string $jobId
     * @param int $limit
     * @param string $langIso
     * @param int $scriptStartTime
     *
     * @return array
     *
     * @throws PrestaShopDatabaseException|EnvVarException
     */
    public function handleIncrementalSync(PaginatedApiDataProviderInterface $dataProvider, $type, $jobId, $limit, $langIso, $scriptStartTime)
    {
        $response = [];

        $incrementalData = $dataProvider->getFormattedDataIncremental($limit, $langIso);

        $objectIds = $incrementalData['ids'];
        $data = $incrementalData['data'];

        if (!empty($data)) {
            $response = $this->proxyService->upload($jobId, $data, $scriptStartTime);

            if ($response['httpCode'] == 201 && !empty($objectIds)) {
                $this->incrementalSyncRepository->removeIncrementalSyncObjects($type, $objectIds, $langIso);
            }
        }

        $remainingObjects = $this->incrementalSyncRepository->getRemainingIncrementalObjects($type, $langIso);

        return array_merge([
            'total_objects' => count($data),
            'has_remaining_objects' => $remainingObjects > 0,
            'remaining_objects' => $remainingObjects,
            'md5' => $this->getPayloadMd5($data),
        ], $response);
    }

    /**
     * @param array $payload
     *
     * @return string
     */
    private function getPayloadMd5($payload)
    {
        return md5(
            implode(' ', array_map(function ($payloadItem) {
                return $payloadItem['id'];
            }, $payload))
        );
    }
}
