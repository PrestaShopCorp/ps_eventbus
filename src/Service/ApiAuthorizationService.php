<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Api\CloudSyncClient;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\CloudSyncUnreachableException;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Exception\JobIdValidationException;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Repository\SyncRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ApiAuthorizationService
{
    /** @var SyncRepository */
    private $syncRepository;

    /** @var CloudSyncClient */
    private $cloudSyncClient;

    /** @var PsAccountsAdapterService */
    private $psAccountsAdapterService;

    /** @var ErrorHandler */
    private $errorHandler;

    public function __construct(
        SyncRepository $syncRepository,
        CloudSyncClient $cloudSyncClient,
        PsAccountsAdapterService $psAccountsAdapterService,
        ErrorHandler $errorHandler
    ) {
        $this->syncRepository = $syncRepository;
        $this->cloudSyncClient = $cloudSyncClient;
        $this->psAccountsAdapterService = $psAccountsAdapterService;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param string $jobId
     * @param bool $isHealthCheck
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException|EnvVarException|FirebaseException
     */
    public function authorize($jobId, $isHealthCheck)
    {
        try {
            $authorizationResponse = $this->authorizeCall($jobId);

            if (!$authorizationResponse) {
                throw new \PrestaShopDatabaseException('Failed saving job id to database');
            }

            try {
                $token = $this->psAccountsAdapterService->getShopToken();
            } catch (\Exception $exception) {
                throw new FirebaseException($exception->getMessage());
            }

            if (!$token) {
                throw new FirebaseException('Invalid token');
            }

            return true;
        } catch (\Exception $exception) {
            // For ApiHealthCheck, handle the error, and return false
            if ($isHealthCheck) {
                return false;
            }

            switch ($exception) {
                case $exception instanceof \PrestaShopDatabaseException:
                case $exception instanceof CloudSyncUnreachableException:
                case $exception instanceof EnvVarException:
                case $exception instanceof FirebaseException:
                case $exception instanceof JobIdValidationException:
                    $this->errorHandler->handle($exception);
                    break;
                default:
                    break;
            }

            return false;
        }
    }

    /**
     * Authorizes and cache job ids
     *
     * @param string $jobId
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException
     * @throws CloudSyncUnreachableException
     * @throws JobIdValidationException
     */
    private function authorizeCall($jobId)
    {
        if (empty($jobId)) {
            throw new JobIdValidationException('Missing or empty job_id query parameter');
        }

        // Check if the job already exists
        if ($this->syncRepository->findJobById($jobId)) {
            return true;
        }

        // Check the jobId validity to avoid Denial Of Service
        $jobValidationResponse = $this->cloudSyncClient->validateJobId($jobId);
        $httpCode = (int) $jobValidationResponse['httpCode'];

        if ($httpCode === 0) {
            throw new CloudSyncUnreachableException('Could not reach CloudSync to validate the job id');
        }

        if ($httpCode !== 201) {
            throw new JobIdValidationException(sprintf('CloudSync refused the job id (sync-api answered HTTP %d)', $httpCode));
        }

        if (!$this->syncRepository->insertJob($jobId, date(Config::MYSQL_DATE_FORMAT))) {
            throw new \PrestaShopDatabaseException('Failed saving job id to database');
        }

        return true;
    }
}
