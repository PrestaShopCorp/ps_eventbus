<?php

namespace PrestaShop\Module\PsEventbus\Service;

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
     * @var ProxyService
     */
    private $proxyService;

    public function __construct(\Context $context, DeletedObjectsRepository $deletedObjectsRepository, ProxyService $proxyService)
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
     * @@throws \PrestaShopDatabaseException|EnvVarException
     */
    public function handleDeletedObjectsSync($jobId, $scriptStartTime)
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $deletedObjects = $this->deletedObjectsRepository->getDeletedObjectsGrouped($shopId);

        if (empty($deletedObjects)) {
            return [
              'job_id' => $jobId,
              'total_objects' => 0,
              'syncType' => 'full',
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
              'syncType' => 'full',
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
