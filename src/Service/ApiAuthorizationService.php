<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Api\SyncApiClient;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;

class ApiAuthorizationService
{
    /**
     * @var EventbusSyncRepository
     */
    private $eventbusSyncRepository;

    /**
     * @var SyncApiClient
     */
    private $syncApiClient;

    public function __construct(
        EventbusSyncRepository $eventbusSyncRepository,
        SyncApiClient $syncApiClient
    ) {
        $this->eventbusSyncRepository = $eventbusSyncRepository;
        $this->syncApiClient = $syncApiClient;
    }

    /**
     * Authorizes and cache job ids
     *
     * @param string $jobId
     *
     * @return array<mixed>|bool
     */
    public function authorizeCall($jobId)
    {
        // Check if the job already exists
        $job = $this->eventbusSyncRepository->findJobById($jobId);

        if ($job) {
            return true;
        }

        // Check the jobId validity to avoid Denial Of Service
        $jobValidationResponse = $this->syncApiClient->validateJobId($jobId);

        if (!is_array($jobValidationResponse) || (int) $jobValidationResponse['httpCode'] !== 201) {
            return false;
        }

        // Cache the valid jobId
        return $this->eventbusSyncRepository->insertJob($jobId, date(DATE_ATOM));
    }
}
