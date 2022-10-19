<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Api\EventBusSyncClient;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShopDatabaseException;

class ApiAuthorizationService
{
    /**
     * @var EventbusSyncRepository
     */
    private $eventbusSyncStateRepository;
    /**
     * @var EventBusSyncClient
     */
    private $eventBusSyncClient;

    public function __construct(
        EventbusSyncRepository $eventbusSyncStateRepository,
        EventBusSyncClient $eventBusSyncClient
    ) {
        $this->eventbusSyncStateRepository = $eventbusSyncStateRepository;
        $this->eventBusSyncClient = $eventBusSyncClient;
    }

    /**
     * Authorizes if the call to endpoint is legit and creates sync state if needed
     *
     * @param string $jobId
     *
     * @return array|bool
     *
     * @throws PrestaShopDatabaseException|EnvVarException
     */
    public function authorizeCall($jobId)
    {
        $job = $this->eventbusSyncStateRepository->findJobById($jobId);

        if ($job) {
            return true;
        }

        $jobValidationResponse = $this->eventBusSyncClient->validateJobId($jobId);

        if (is_array($jobValidationResponse) && (int) $jobValidationResponse['httpCode'] === 201) {
            return $this->eventbusSyncStateRepository->insertJob($jobId, date(DATE_ATOM));
        }

        return $jobValidationResponse;
    }
}
