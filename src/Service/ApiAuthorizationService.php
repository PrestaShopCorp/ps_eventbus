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

use PrestaShop\Module\PsEventbus\Api\SyncApiClient;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
