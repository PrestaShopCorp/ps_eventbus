<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\DeletedObjectsRepository;

class DeletedObjectsService
{
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var DeletedObjectsRepository
     */
    private $deletedObjectsRepository;
    /**
     * @var ProxyServiceInterface
     */
    private $proxyService;

    public function __construct(\Context $context, DeletedObjectsRepository $deletedObjectsRepository, ProxyServiceInterface $proxyService)
    {
        $this->context = $context;
        $this->deletedObjectsRepository = $deletedObjectsRepository;
        $this->proxyService = $proxyService;
    }

    /**
     * @param string $jobId
     * @param int $scriptStartTime
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException|EnvVarException
     */
    public function handleDeletedObjectsSync($jobId, $scriptStartTime)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $deletedObjects = $this->deletedObjectsRepository->getDeletedObjectsGrouped($shopId);

        if (empty($deletedObjects)) {
            return [
                'total_objects' => 0,
            ];
        }

        $data = $this->formatData($deletedObjects);

        $response = $this->proxyService->delete($jobId, $data, $scriptStartTime);

        if ($response['httpCode'] == 200) {
            foreach ($data as $dataItem) {
                $this->deletedObjectsRepository->removeDeletedObjects(
                    $dataItem['collection'],
                    $dataItem['deleteIds'],
                    $shopId
                );
            }
        }

        return array_merge(
            [
                'job_id' => $jobId,
                'total_objects' => count($data),
            ],
            $response
        );
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function formatData(array $data)
    {
        return array_map(function ($dataItem) {
            return [
                'collection' => $dataItem['type'],
                'deleteIds' => explode(';', $dataItem['ids']),
            ];
        }, $data);
    }
}
